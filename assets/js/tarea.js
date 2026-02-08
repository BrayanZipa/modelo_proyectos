let tabla;

$(function() {

    // FUnción para inicializar DataTable de tareas
    function initDataTable(usuarioId) {
        if (tabla) {
            tabla.destroy();
        }

        tabla = $('#tareasTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: true,
            pageLength: 10,
            order: [[0, 'desc']],
            ajax: {
                url: `/api/usuarios/${usuarioId}/tareas`,
                data: function (d) {
                    d.search = $('#search').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'descripcion', name: 'descripcion' },
                { data: 'proyecto', name: 'proyecto' },
                { data: 'tarifa', name: 'tarifa',
                    render: function(data, type, row) {
                        if (data === null) return '';
                        return new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(data);
                    }
                },
                { data: 'estado', name: 'estado' },
                { data: 'createdAt', name: 'createdAt',
                    render: function(data) {
                        const d = new Date(data);
                        const day = String(d.getDate()).padStart(2, '0');
                        const month = String(d.getMonth() + 1).padStart(2, '0');
                        const year = d.getFullYear();
                        return `${day}/${month}/${year}`;
                    }
                }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.2/i18n/es-CO.json'
            }
        });
    }

    initDataTable($('#usuarioSelect').val());

    $('#usuarioSelect').on('change', function() {
        initDataTable(this.value);
    });

    $('#search').on('keyup', function() {
        tabla.search(this.value).draw();
    });
});