<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'stake_base_amount',
        'max_stake_level',
        'target_bankroll_growth',
        'auto_adjust_stakes',
        'min_confidence_threshold',
        'stake_mapping',
        'auto_stake_enabled',
        'conservative_mode',
        'preferred_markets',
        'excluded_leagues',
        'email_predictions',
        'high_confidence_alerts'
    ];

    protected $casts = [
        'stake_base_amount' => 'decimal:2',
        'target_bankroll_growth' => 'decimal:2',
        'auto_adjust_stakes' => 'boolean',
        'min_confidence_threshold' => 'decimal:2',
        'stake_mapping' => 'array',
        'preferred_markets' => 'array',
        'excluded_leagues' => 'array',
        'auto_stake_enabled' => 'boolean',
        'conservative_mode' => 'boolean',
        'email_predictions' => 'boolean',
        'high_confidence_alerts' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Método para calcular stake basado en confidence score
    public function calculateStake($confidenceScore)
    {
        if (!$this->auto_stake_enabled) {
            return 5; // Stake por defecto
        }

        // Si hay mapeo personalizado, usarlo
        if ($this->stake_mapping) {
            return $this->getStakeFromMapping($confidenceScore);
        }

        // Mapeo por defecto
        return $this->getDefaultStake($confidenceScore);
    }

    private function getStakeFromMapping($confidenceScore)
    {
        $mapping = $this->stake_mapping;

        foreach ($mapping as $threshold => $stake) {
            if ($confidenceScore >= $threshold) {
                return $stake;
            }
        }

        return 1; // Mínimo stake
    }

    private function getDefaultStake($confidenceScore)
    {
        // Nuevo sistema 1-4 stakes
        if ($confidenceScore >= 90) return 4;
        if ($confidenceScore >= 80) return 3;
        if ($confidenceScore >= 70) return 2;
        if ($confidenceScore >= 60) return 1;
        return 0; // No apostar
    }

    // Método para calcular monto real en COP con stake base configurable
    public function calculateBetAmount($stake)
    {
        // Sistema configurable: stake_base_amount por unidad
        // Ejemplo: 5,000 COP base × stake 3 = 15,000 COP
        return $stake * $this->stake_base_amount;
    }

    // Verificar si necesita ajustar stakes por crecimiento de bankroll
    public function shouldAdjustStakes($currentBankroll)
    {
        if (!$this->auto_adjust_stakes || !$this->target_bankroll_growth) {
            return false;
        }

        return $currentBankroll >= $this->target_bankroll_growth;
    }

    // Sugerir nuevo stake base cuando se alcance la meta
    public function getSuggestedNewStakeBase($currentBankroll, $initialBankroll = 100000)
    {
        if (!$this->target_bankroll_growth) {
            return $this->stake_base_amount;
        }

        // Calcular proporción de crecimiento desde el bankroll inicial
        $growthRatio = $currentBankroll / $initialBankroll;
        $newStakeBase = 5000 * $growthRatio; // Base original * crecimiento

        // Redondear a múltiplos de 1000 para facilidad
        return round($newStakeBase / 1000) * 1000;
    }

    // Obtener rango de apuestas actual
    public function getBettingRange()
    {
        $min = $this->stake_base_amount; // Stake 1
        $max = $this->stake_base_amount * $this->max_stake_level; // Stake máximo

        return [
            'min' => $min,
            'max' => $max,
            'range' => "1-{$this->max_stake_level}",
            'amounts' => [
                1 => $this->stake_base_amount,
                2 => $this->stake_base_amount * 2,
                3 => $this->stake_base_amount * 3,
                4 => $this->stake_base_amount * 4,
            ]
        ];
    }

    public function shouldCreatePrediction($confidenceScore)
    {
        return $confidenceScore >= $this->min_confidence_threshold;
    }
}
