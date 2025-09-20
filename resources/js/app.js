import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Importar DataTables y estilos de Bootstrap 5
import 'datatables.net-bs5';
import 'datatables.net-responsive-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

// Inicializar DataTables cuando el DOM esté listo
$(document).ready(function() {
    $('#teams-table').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        },
        lengthMenu: [5, 10, 25, 50, 100], // Opciones de paginación
        order: [[1, 'asc']], // Ordenar por la columna de la liga
    });
});
