<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<!-- Contenido de la página -->
<div class="container">
    <!-- Aquí va el contenido del carrito -->
</div>

<!-- Modal de éxito -->
<div class="modal fade" id="modalExito" tabindex="-1" role="dialog" aria-labelledby="modalExitoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExitoLabel">¡Pago Exitoso!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                El pago se ha realizado con éxito.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de error -->
<div class="modal fade" id="modalError" tabindex="-1" role="dialog" aria-labelledby="modalErrorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalErrorLabel">¡Error en el Pago!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Ha ocurrido un error al procesar el pago. Por favor, inténtelo de nuevo más tarde.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Scripts adicionales -->
<script>
    // Función para mostrar el modal de éxito
    function mostrarModalExito() {
        $('#modalExito').modal('show');
    }

    // Función para mostrar el modal de error
    function mostrarModalError() {
        $('#modalError').modal('show');
    }

    // Ejemplo de llamada a las funciones
    // Reemplaza este ejemplo con tu lógica real para mostrar los modales en el momento adecuado
    $(document).ready(function() {
        // Ejemplo de mostrar el modal de éxito después de 2 segundos
        setTimeout(mostrarModalExito, 2000);

        // Ejemplo de mostrar el modal de error después de 3 segundos
        setTimeout(mostrarModalError, 3000);
    });
</script>

</body>
</html>
