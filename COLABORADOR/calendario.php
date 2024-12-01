<!DOCTYPE html>
<html>
<?php 
    // Obtiene el ID del usuario de la sesión
    $id = $_SESSION['user_id'];
?>
<head>
    <!-- Configuración del documento -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- Estilos del calendario -->
	<link rel="stylesheet" type="text/css" href="calendario/css/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="calendario/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="calendario/css/home.css">
</head>
<body>

<?php
    // Consulta para obtener los eventos del usuario actual
    $SqlEventos   = ("SELECT * FROM calendario WHERE usuario = $id");
    $resulEventos = mysqli_query($link, $SqlEventos);
?>

<!-- Espaciado superior -->
<div class="mt-5"></div>

<div class="container">
    <div class="row">
        <div class="col msjs">
            <?php
                // Incluye mensajes del sistema desde otro archivo
                include('calendario/msjs.php');
            ?>
        </div>
    </div>
</div>

<!-- Contenedor del calendario -->
<div id="calendar"></div>

<?php  
    // Incluye los modales para crear y editar eventos
    include('calendario/modalNuevoEvento.php');
    include('calendario/modalUpdateEvento.php');
?>

<!-- Scripts necesarios para el funcionamiento del calendario -->
<script src ="calendario/js/jquery-3.0.0.min.js"> </script>
<script src="calendario/js/popper.min.js"></script>
<script src="calendario/js/bootstrap.min.js"></script>
<script type="text/javascript" src="calendario/js/moment.min.js"></script>	
<script type="text/javascript" src="calendario/js/fullcalendar.min.js"></script>
<script src='calendario/locales/es.js'></script>

<script type="text/javascript">
// Configuración de FullCalendar
$(document).ready(function() {
    $("#calendar").fullCalendar({
        // Configuración de encabezado
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        locale: 'es', // Idioma español
        defaultView: "month", // Vista predeterminada
        navLinks: true, // Habilita enlaces de navegación
        editable: true, // Permite editar eventos
        eventLimit: true, // Limita el número de eventos visibles
        selectable: true, // Permite seleccionar fechas
        selectHelper: false, // Deshabilita el asistente de selección

        // Evento para crear un nuevo evento
        select: function(start, end){
            $("#exampleModal").modal(); // Abre el modal de creación
            $("input[name=fecha_inicio]").val(start.format('YYYY-MM-DD')); // Fecha inicio
            $("input[name=hora_inicio]").val(start.format('HH:mm')); // Hora inicio
            $("input[name=fecha_fin]").val(end.format('YYYY-MM-DD')); // Fecha fin
            $("input[name=hora_fin]").val(end.format('HH:mm')); // Hora fin
        },

        // Eventos cargados desde la base de datos
        events: [
            <?php
            // Itera sobre los resultados de la consulta
            while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?>
                {
                    _id: '<?php echo $dataEvento['identificador']; ?>', // ID del evento
                    title: '<?php echo $dataEvento['evento']; ?>', // Título del evento
                    start: '<?php echo $dataEvento['fecha_inicio'] . "T" . $dataEvento['hora_inicio']; ?>', // Inicio
                    end: '<?php echo $dataEvento['fecha_inicio'] . "T" . $dataEvento['hora_fin']; ?>', // Fin
                    observaciones: '<?php echo $dataEvento['observaciones']; ?>', // Observaciones
                    color: '<?php echo $dataEvento['color_evento']; ?>' // Color del evento
                },
            <?php } ?>
        ],

        // Eliminar un evento
        eventRender: function(event, element) {
            // Agrega un botón de cerrar en cada evento
            element.find(".fc-content").prepend("<span id='btnCerrar' class='closeon material-icons'>&#xe5cd;</span>");
            element.find(".closeon").on("click", function() {
                // Confirmación para eliminar el evento
                var pregunta = confirm("Deseas Borrar este Evento?");
                if (pregunta) {
                    // Elimina el evento del calendario
                    $("#calendar").fullCalendar("removeEvents", event._id);
                    // Realiza una petición AJAX para eliminarlo de la base de datos
                    $.ajax({
                        type: "POST",
                        url: 'calendario/deleteEvento.php',
                        data: { id: event._id },
                        success: function(datos) {
                            // Muestra una notificación de éxito
                            $(".alert-danger").show();
                            setTimeout(function () {
                                $(".alert-danger").slideUp(500);
                            }, 3000);
                        }
                    });
                }
            });
        },

        // Arrastrar y soltar un evento
        eventDrop: function(event, delta) {
            // Obtiene los datos del evento modificado
            var idEvento = event._id;
            var start = (event.start.format('YYYY-MM-DDTHH:mm:ss'));
            var end = (event.end ? event.end.format("YYYY-MM-DDTHH:mm:ss") : start);

            // Actualiza los datos en la base de datos mediante AJAX
            $.ajax({
                url: 'drag_drop_evento.php',
                data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
                type: "POST",
                success: function(response) {}
            });
        },

        // Modificar un evento del calendario
        eventClick: function(event) {
            // Carga los datos del evento en el modal de edición
            var idEvento = event._id;
            $('input[name=idEvento]').val(idEvento);
            $('input[name=evento]').val(event.title);
            $('input[name=fecha_inicio]').val(event.start.format('YYYY-MM-DD'));
            $('input[name=hora_inicio]').val(event.start.format('HH:mm'));
            $('input[name=fecha_fin]').val(event.end ? event.end.format('YYYY-MM-DD') : '');
            $('input[name=hora_fin]').val(event.end ? event.end.format('HH:mm') : '');
            $('input[name=observaciones]').val(event.observaciones);

            // Muestra el modal de edición
            $("#modalUpdateEvento").modal();
        }
    });

    // Oculta mensajes de notificación después de 3 segundos
    setTimeout(function () {
        $(".alert").slideUp(300);
    }, 3000);
});
</script>

</body>
</html>
