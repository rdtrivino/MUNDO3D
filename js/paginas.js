// paginacion.js

// Variables globales
let currentPage = 1; // Página actual
const totalPages = 3; // Número total de páginas

// Función para cambiar de página
function changePage(pageNumber) {
  // Validar que el número de página esté dentro del rango.
  if (pageNumber >= 1 && pageNumber <= totalPages) {
    // Aquí puedes agregar lógica para cargar contenido diferente o realizar otras acciones según la página seleccionada.

    // Actualiza la página actual.
    currentPage = pageNumber;

    // Actualiza el texto de información de página.
    document.getElementById("pageInfo").textContent = `Page ${currentPage} of ${totalPages}`;

    // Actualiza la apariencia de los botones de paginación.
    updatePaginationButtons();
  }
}

// Función para actualizar la apariencia de los botones de paginación
function updatePaginationButtons() {
  // Obtén todos los botones de paginación.
  const paginationButtons = document.querySelectorAll(".button");

  // Recorre los botones y marca el botón activo y desactiva los demás según la página actual.
  paginationButtons.forEach((button, index) => {
    if (index + 1 === currentPage) {
      button.classList.add("active");
    } else {
      button.classList.remove("active");
    }
  });
}

// Evento para cargar la página inicialmente.
window.onload = function () {
  // Actualiza la apariencia inicial de los botones de paginación.
  updatePaginationButtons();
};
