function buscarProductos() {
    var input = document.getElementById("search-input").value;
    var resultsContainer = document.getElementById("search-results");

    // Limpia el contenedor de resultados si no hay entrada de búsqueda
    if (input.trim() === "") {
        resultsContainer.innerHTML = "";
        return;
    }

    // Realiza una solicitud AJAX para buscar productos
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Muestra los resultados de la búsqueda en el contenedor
            resultsContainer.innerHTML = xhr.responseText;
        }
    };

    // Define la URL del archivo PHP que procesará la búsqueda
    var url = "../MUNDO 3D/Programas/buscarProductos.php" + encodeURIComponent(input);

    // Agrega el término de búsqueda a la URL
    url += "?q=" + encodeURIComponent(input);

    // Realiza la solicitud AJAX
    xhr.open("GET", url, true);
    xhr.send();
}
