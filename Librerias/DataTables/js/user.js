$(document).ready( function () {
    $('#table_id').DataTable({
        language: {
            processing:     "Procesamiento en curso...",
            search:         "Buscar:" ,
            lengthMenu:    "Filtro de _MENU_",
            info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty:      "No existen registros",
            infoFiltered:   "(filtrado de _MAX_ registros en total)",
            infoPostFix:    "",
            loadingRecords: "Cargando elementos...",
            zeroRecords:    "No se encontraron los datos de tu busquda..",
            emptyTable:     "No hay ningun registro en la tabla",
            paginate: {
                first:      "Primero",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Último"
            },
            aria: {
                sortAscending:  ": Active para odernar en modo ascendente",
                sortDescending: ": Active para ordenar en modo descendente  ",
            }
}
    } );
} );
