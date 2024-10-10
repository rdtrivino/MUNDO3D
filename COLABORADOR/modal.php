<div class="modal fade" id="productosModal" tabindex="-1" aria-labelledby="productosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 90%; margin: 5% auto;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex align-items-center">
                    <img class="logo" src="../images/Logo Mundo 3d.png" alt="Logo de la empresa" style="max-width: 100px;">
                    <h5 class="modal-title" id="productosModalLabel">Selecciona el tipo de producto a incluir</h5>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="producto-btn" data-bs-dismiss="modal">Producto</button>
                <button type="button" class="btn btn-secondary" id="impresion-btn" data-bs-dismiss="modal">Impresión</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let producto = ""; // Variable para almacenar la selección

        // Capturar selección de "Producto"
        document.getElementById('producto-btn').addEventListener('click', function () {
            producto = "Producto";
            console.log("Seleccionado:", producto); // Aquí puedes hacer algo más con esta variable
        });

        // Capturar selección de "Impresión"
        document.getElementById('impresion-btn').addEventListener('click', function () {
            producto = "Impresión";
            console.log("Seleccionado:", producto); // Aquí puedes hacer algo más con esta variable
        });

        // El botón de cerrar solo cierra el modal gracias a data-bs-dismiss="modal"
    });
</script>
