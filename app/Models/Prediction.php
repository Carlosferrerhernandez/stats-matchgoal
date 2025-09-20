<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'match_id',
        'market_id',
        'user_id',
        'prediction',
        'confidence_score',
        'suggested_stake',
        'bet_amount',
        'expected_odds',
        'reasoning',
        'status',
        'result',
        'actual_odds',
        'profit_loss',
        'net_profit',
        'roi_percentage',
        'placed_at',
        'bookmaker'
    ];

    protected $casts = [
        'confidence_score' => 'decimal:2',
        'expected_odds' => 'decimal:2',
        'actual_odds' => 'decimal:2',
        'profit_loss' => 'decimal:2',
        'bet_amount' => 'decimal:2',
        'net_profit' => 'decimal:2',
        'roi_percentage' => 'decimal:2',
        'result' => 'boolean',
        'placed_at' => 'datetime',
    ];

    public function match()
    {
        return $this->belongsTo(FootballMatch::class, 'match_id');
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_PLACED = 'placed';
    const STATUS_WON = 'won';
    const STATUS_LOST = 'lost';
    const STATUS_VOID = 'void';

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isPlaced()
    {
        return $this->status === self::STATUS_PLACED;
    }

    public function isWon()
    {
        return $this->status === self::STATUS_WON;
    }

    public function isLost()
    {
        return $this->status === self::STATUS_LOST;
    }

    // Métodos para sistema COP con stake base configurable
    public function calculateBetAmountCOP()
    {
        $userSettings = $this->user->settings;
        if (!$userSettings) {
            // Fallback: 5,000 COP por stake (tu configuración default)
            return $this->suggested_stake * 5000;
        }

        return $userSettings->calculateBetAmount($this->suggested_stake);
    }

    public function calculateProfitLoss()
    {
        if (!$this->actual_odds || !$this->bet_amount) {
            return null;
        }

        if ($this->result === true) {
            // Ganó: (monto apostado * cuota) - monto apostado
            $totalReturn = $this->bet_amount * $this->actual_odds;
            $netProfit = $totalReturn - $this->bet_amount;
            return $netProfit;
        } else {
            // Perdió: -monto apostado
            return -$this->bet_amount;
        }
    }

    public function calculateROI()
    {
        $profitLoss = $this->calculateProfitLoss();
        if ($profitLoss === null || !$this->bet_amount) {
            return null;
        }

        return ($profitLoss / $this->bet_amount) * 100;
    }

    public function updateResults($won, $actualOdds, $bookmaker = null)
    {
        $this->result = $won;
        $this->actual_odds = $actualOdds;
        $this->bookmaker = $bookmaker;
        $this->status = $won ? self::STATUS_WON : self::STATUS_LOST;

        // Calcular monto si no existe
        if (!$this->bet_amount) {
            $this->bet_amount = $this->calculateBetAmountCOP();
        }

        // Calcular ganancias
        $this->profit_loss = $this->calculateProfitLoss();
        $this->net_profit = $won ? $this->profit_loss : 0;
        $this->roi_percentage = $this->calculateROI();

        $this->save();

        return $this;
    }

    // Helper para mostrar montos formateados
    public function getBetAmountFormattedAttribute()
    {
        return number_format($this->bet_amount, 0, ',', '.') . ' COP';
    }

    public function getProfitLossFormattedAttribute()
    {
        $prefix = $this->profit_loss >= 0 ? '+' : '';
        return $prefix . number_format($this->profit_loss, 0, ',', '.') . ' COP';
    }
}
