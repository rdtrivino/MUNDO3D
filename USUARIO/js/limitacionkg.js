// Agregar un "listener" al evento "change" del campo de archivo
document.getElementById("archivoImpresion").addEventListener("change", function () {
    // Obtener el archivo seleccionado por el usuario
    var archivo = this.files[0]; 

    // Establecer el límite de tamaño para el archivo (500 KB)
    var limiteTamaño = 500 * 1024; // 500 KB en bytes

    // Validar si el tamaño del archivo supera el límite permitido
    if (archivo.size > limiteTamaño) {
        // Mostrar un mensaje de advertencia con SweetAlert
        Swal.fire({
            icon: 'error', // Ícono para indicar error
            title: 'Archivo demasiado grande', // Título del mensaje
            text: 'El archivo supera el tamaño máximo permitido de 500 KB. Por favor, selecciona otro archivo.', // Descripción
            confirmButtonText: 'Entendido' // Texto del botón de confirmación
        });

        // Limpiar el input para que el archivo seleccionado no sea válido
        this.value = ""; 
    }
});
