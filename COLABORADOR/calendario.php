<!DOCTYPE html>
<html>
<?php 

    $id = $_SESSION['user_id']
?>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="calendario/css/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="calendario/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="calendario/css/home.css">
</head>
<body>

<?php

  $SqlEventos   = ("SELECT * FROM calendario WHERE usuario = $id");
  $resulEventos = mysqli_query($link, $SqlEventos);

?>
<div class="mt-5"></div>

<div class="container">
  <div class="row">
    <div class="col msjs">
      <?php
        include('calendario/msjs.php');
      ?>
    </div>
  </div>
</div>

<div id="calendar"></div>


<?php  
  include('calendario/modalNuevoEvento.php');
  include('calendario/modalUpdateEvento.php');
?>

<script src ="calendario/js/jquery-3.0.0.min.js"> </script>
<script src="calendario/js/popper.min.js"></script>
<script src="calendario/js/bootstrap.min.js"></script>

<script type="text/javascript" src="calendario/js/moment.min.js"></script>	
<script type="text/javascript" src="calendario/js/fullcalendar.min.js"></script>
<script src='calendario/locales/es.js'></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#calendar").fullCalendar({
        header: {
            left: "prev,next today",
            center: "title",
            right: "month,agendaWeek,agendaDay"
        },
        locale: 'es',
        defaultView: "month",
        navLinks: true, 
        editable: true,
        eventLimit: true, 
        selectable: true,
        selectHelper: false,

        // Nuevo Evento
        select: function(start, end){
            $("#exampleModal").modal();
            $("input[name=fecha_inicio]").val(start.format('YYYY-MM-DD'));
            $("input[name=hora_inicio]").val(start.format('HH:mm'));
            
            $("input[name=fecha_fin]").val(end.format('YYYY-MM-DD'));
            $("input[name=hora_fin]").val(end.format('HH:mm'));
        },

        events: [
            <?php
            while ($dataEvento = mysqli_fetch_array($resulEventos)) { ?>
                {
                    _id: '<?php echo $dataEvento['identificador']; ?>',
                    title: '<?php echo $dataEvento['evento']; ?>',
                    start: '<?php echo $dataEvento['fecha_inicio'] . "T" . $dataEvento['hora_inicio']; ?>',
                    end: '<?php echo $dataEvento['fecha_inicio'] . "T" . $dataEvento['hora_fin']; ?>',
                    observaciones: '<?php echo $dataEvento['observaciones']; ?>',
                    //end: '<?php //echo $dataEvento['fecha_fin'] . "T" . $dataEvento['hora_fin']; ?>',
                    color: '<?php echo $dataEvento['color_evento']; ?>'
                },
            <?php } ?>
        ],

        // Eliminar Evento
        eventRender: function(event, element) {
            element.find(".fc-content").prepend("<span id='btnCerrar' class='closeon material-icons'>&#xe5cd;</span>");
            element.find(".closeon").on("click", function() {
                var pregunta = confirm("Deseas Borrar este Evento?");
                if (pregunta) {
                    $("#calendar").fullCalendar("removeEvents", event._id);
                    $.ajax({
                        type: "POST",
                        url: 'calendario/deleteEvento.php',
                        data: { id: event._id },
                        success: function(datos) {
                            $(".alert-danger").show();
                            setTimeout(function () {
                                $(".alert-danger").slideUp(500);
                            }, 3000);
                        }
                    });
                }
            });
        },

        // Moviendo Evento Drag - Drop
        eventDrop: function(event, delta) {
            var idEvento = event._id;
            var start = (event.start.format('YYYY-MM-DDTHH:mm:ss'));
            var end = (event.end ? event.end.format("YYYY-MM-DDTHH:mm:ss") : start);

            $.ajax({
                url: 'drag_drop_evento.php',
                data: 'start=' + start + '&end=' + end + '&idEvento=' + idEvento,
                type: "POST",
                success: function(response) {}
            });
        },

        // Modificar Evento del Calendario 
        eventClick: function(event) {
            var idEvento = event._id;
            $('input[name=idEvento]').val(idEvento);
            $('input[name=evento]').val(event.title);
            $('input[name=fecha_inicio]').val(event.start.format('YYYY-MM-DD'));
            $('input[name=hora_inicio]').val(event.start.format('HH:mm'));
            $('input[name=fecha_fin]').val(event.end ? event.end.format('YYYY-MM-DD') : '');
            $('input[name=hora_fin]').val(event.end ? event.end.format('HH:mm') : '');
            $('input[name=observaciones]').val(event.observaciones);

            $("#modalUpdateEvento").modal();
        }
    });

    // Oculta mensajes de Notificación
    setTimeout(function () {
        $(".alert").slideUp(300);
    }, 3000);
});

</script>


</body>
</html>
