// Función para hacer una solicitud AJAX al servidor y obtener el nombre de usuario
function getUsername() {
	var xhr = new XMLHttpRequest()
	xhr.open('GET', '../Programas/get_username.php', true)
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			// Parsea la respuesta JSON para obtener el objeto de usuario
			var userData = JSON.parse(xhr.responseText)
			// Obtiene el nombre completo del objeto de usuario
			var nombreCompleto = userData.nombreCompleto
			// Actualiza el contenido del elemento user-name con el nombre completo de usuario
			document.getElementById('user-name').textContent =
				'Bienvenid@ ' + nombreCompleto
		}
	}
	xhr.send()
}

// Llama a la función getUsername al cargar la página para obtener el nombre de usuario
window.onload = function () {
	getUsername()
}
//accesibilidad --------------------------------------------------------------------------------------------------
function adjustFontSize(size) {
	const body = document.body
	body.classList.remove('font-small', 'font-medium', 'font-large')

	switch (size) {
		case 'small':
			body.classList.add('font-small')
			break
		case 'medium':
			body.classList.add('font-medium')
			break
		case 'large':
			body.classList.add('font-large')
			break
	}
}

function aumentarTamano() {
	// Funcionalidad específica para el icono de silla de ruedas
}

function cambiarCursor(event) {
	event.target.style.cursor = 'pointer'
}

function restaurarCursor(event) {
	event.target.style.cursor = 'default'
}
//----------------------------------------------------------------------------------------------------
// menu desplegable
document
	.getElementById('menu-toggle')
	.addEventListener('click', function (event) {
		var menu = document.getElementById('dropdown-menu')
		menu.style.display = menu.style.display === 'block' ? 'none' : 'block'
		event.stopPropagation() // Evita que el clic en el botón se propague al documento
	})

// Event listener para cerrar el menú desplegable cuando se hace clic fuera de él
document.addEventListener('click', function (event) {
	var menu = document.getElementById('dropdown-menu')
	var menuToggle = document.getElementById('menu-toggle')
	if (!menu.contains(event.target) && event.target !== menuToggle) {
		menu.style.display = 'none'
	}
})

function confirmLogout() {
	Swal.fire({
		title: '¿Estás seguro?',
		text: '¿Realmente quieres cerrar sesión?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#dc3545',
		cancelButtonColor: '#6c757d',
		confirmButtonText: 'Sí, cerrar sesión',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			Swal.fire({
				title: '¡Sesión cerrada!',
				text: 'Has cerrado sesión exitosamente.',
				icon: 'success',
				timer: 2000,
				showConfirmButton: false
			}).then(() => {
				// Redirige al script de cierre de sesión después de mostrar la alerta
				window.location.href = '../Programas/logout.php'
			});
		}
	});
}

//vaciar carrito ________________________________________________________________________________________________________
function vaciarCarrito() {
	console.log('Vaciar carrito función llamada') // Añade esto para depuración
	Swal.fire({
		title: '¿Estás seguro?',
		text: '¿Quieres vaciar el carrito?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#dc3545',
		cancelButtonColor: '#6c757d',
		confirmButtonText: 'Sí, vaciar',
		cancelButtonText: 'Cancelar'
	}).then(result => {
		if (result.isConfirmed) {
			console.log('Confirmación recibida') // Añade esto para depuración
			var xhr = new XMLHttpRequest()
			xhr.open('POST', 'programas/funciones-in-re.php', true)
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					Swal.fire({
						title: '¡Buen trabajo!',
						text: '¡El carrito ha sido vaciado!',
						icon: 'success'
					}).then(() => {
						// Actualizar la vista del carrito en la página después de mostrar la alerta
						document.getElementById('carritoContenido').innerHTML =
							'<p>El carrito está vacío.</p>'
						document.getElementById('totalProductos').innerHTML =
							'Total a pagar: $0'
						// Opcional: Recargar la página para asegurar que todos los cambios se reflejen
						location.reload()
					})
				}
			}
			xhr.send('action=vaciar_carrito')
		}
	})
}

// Función para actualizar la cantidad de productos en el carrito
function actualizarCantidad(id, action) {
	var xhr = new XMLHttpRequest()
	xhr.open('POST', 'programas/funciones-in-re.php', true)
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4 && xhr.status === 200) {
			// Recargar la página o actualizar la vista del carrito dinámicamente
			location.reload()
		}
	}
	xhr.send('action=actualizar_cantidad&id=' + id + '&action_type=' + action)
}

// Función para eliminar un producto del carrito
function eliminarProducto(id) {
	Swal.fire({
		title: '¿Estás seguro?',
		text: '¿Quieres eliminar este producto?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#dc3545',
		cancelButtonColor: '#6c757d',
		confirmButtonText: 'Sí, eliminar',
		cancelButtonText: 'Cancelar'
	}).then(result => {
		if (result.isConfirmed) {
			var xhr = new XMLHttpRequest()
			xhr.open('POST', 'programas/funciones-in-re.php', true)
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					Swal.fire({
						title: '¡Eliminado!',
						text: '¡El producto ha sido eliminado!',
						icon: 'success'
					}).then(() => {
						// Recargar la página para reflejar los cambios
						location.reload()
					})
				}
			}
			xhr.send('action=eliminar_producto&id=' + id)
		}
	})
}

// Event listeners para los botones del carrito
document.addEventListener('DOMContentLoaded', function () {
	// Incrementar/decrementar cantidad
	document.querySelectorAll("[data-action='increment']").forEach(button => {
		button.addEventListener('click', function () {
			var id = this.getAttribute('data-id')
			actualizarCantidad(id, 'increment')
		})
	})

	document.querySelectorAll("[data-action='decrement']").forEach(button => {
		button.addEventListener('click', function () {
			var id = this.getAttribute('data-id')
			actualizarCantidad(id, 'decrement')
		})
	})

	// Eliminar producto
	document.querySelectorAll("[data-action='remove']").forEach(button => {
		button.addEventListener('click', function () {
			var id = this.getAttribute('data-id')
			eliminarProducto(id)
		})
	})
})

//ir a pagar_______________________________________________________________________________________________________
document.addEventListener('DOMContentLoaded', function () {
	// Obtener referencia al botón "Ir a pagar"
	var irAPagarBtn = document.getElementById('irAPagarBtn')

	// Agregar un evento clic al botón
	irAPagarBtn.addEventListener('click', function (event) {
		// Aquí puedes agregar la lógica para redirigir al usuario a la página de pago
		// Utiliza una ruta absoluta y barras inclinadas hacia adelante
		window.location.href = 'redireccionar.php'
	})
})
// agregar al carrito__________________________________________________________________________________________________

// Variable para almacenar los productos en el carrito
var carritoProductos = []

// Función para agregar un producto al carrito
function agregarAlCarrito(producto) {
	// Agregar el producto al arreglo de productos en el carrito
	carritoProductos.push(producto)

	// Mostrar el carrito actualizado
	mostrarCarrito()

	// Actualizar el contador de productos
	actualizarContadorProductos()

	// Enviar datos del producto al servidor mediante AJAX
	var xhr = new XMLHttpRequest()
	xhr.open('POST', '', true) // El mismo archivo PHP
	xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xhr.onreadystatechange = function () {
		if (xhr.readyState === XMLHttpRequest.DONE) {
			if (xhr.status === 200) {
				console.log(xhr.responseText) // Puedes mostrar un mensaje de éxito en la consola
				// Recargar la página después de agregar un producto
				location.reload()
			} else {
				console.error('Error al guardar el producto en el carrito.')
			}
		}
	}

	// Convertir el objeto producto a una cadena JSON para enviarlo al servidor
	var data = JSON.stringify(producto)
	xhr.send('producto=' + encodeURIComponent(data))
}

// Función para actualizar el contador de productos en el botón del carrito
function actualizarContadorProductos() {
	// Filtrar los productos en el carrito que tengan estado de pago "pendiente"
	var productosPendientes = carritoProductos.filter(function (producto) {
		return producto.estado_pago === 'pendiente'
	})

	// Actualizar el contador de productos con la longitud del arreglo filtrado
	var contadorProductos = document.getElementById('contadorProductos')
	contadorProductos.textContent = productosPendientes.length

	// Si no hay productos pendientes, mostrar 0 en el contador
	if (productosPendientes.length === 0) {
		contadorProductos.textContent = '0'
	}
}

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function () {
	// Obtener todos los botones "Agregar al carrito"
	var agregarAlCarritoBtns = document.querySelectorAll('.agregarAlCarritoBtn')

	agregarAlCarritoBtns.forEach(function (btn) {
		btn.addEventListener('click', function (event) {
			event.preventDefault()
			var productId = this.getAttribute('data-id')
			var productName = this.getAttribute('data-name')
			var productPrice = parseFloat(this.getAttribute('data-price'))

			// Agregar el producto al carrito
			agregarAlCarrito({
				Identificador: productId,
				nombre: productName,
				precio: productPrice
			})
		})
	})
})

// Función para mostrar el carrito
function mostrarCarrito() {
	var carritoContenido = document.getElementById('carritoContenido')
	var totalProductos = document.getElementById('totalProductos')
	var total = 0

	// Limpiar contenido previo
	carritoContenido.innerHTML = ''

	// Mostrar cada producto en el carrito
	carritoProductos.forEach(function (producto) {
		carritoContenido.innerHTML +=
			'<p>' + producto.nombre + ' - Precio: $' + producto.precio + '</p>'
		total += producto.precio
	})

	// Mostrar el total de todos los productos
	totalProductos.innerHTML = '<p>Total: $' + total + '</p>'
}
// detalles de producto______________________________________________________________________________
document.addEventListener('DOMContentLoaded', function () {
	var detallesBtns = document.querySelectorAll('.detallesBtn')

	detallesBtns.forEach(function (btn) {
		btn.addEventListener('click', function (event) {
			event.preventDefault()
			var productName = this.getAttribute('data-name')
			var productDescription = this.getAttribute('data-description')
			var productPrice = this.getAttribute('data-price')
			var productImage = this.closest('.card')
				.querySelector('.card-img-top')
				.getAttribute('src')

			cargarDetallesProducto(
				productName,
				productDescription,
				productPrice,
				productImage
			)
		})
	})
})

function cargarDetallesProducto(
	productName,
	productDescription,
	productPrice,
	productImage
) {
	var modalImagen = document.getElementById('productoImagen')
	var modalNombre = document.getElementById('productoNombre')
	var modalDescripcion = document.getElementById('productoDescripcion')
	var modalPrecio = document.getElementById('productoPrecio')

	modalImagen.src = productImage
	modalNombre.textContent = productName
	modalDescripcion.textContent = productDescription
	modalPrecio.textContent = 'COP ' + productPrice

	$('#detalleProductoModal').modal('show')
}

// buscador de productos //
document.addEventListener('DOMContentLoaded', function () {
	// Función para buscar productos
	function buscarProducto() {
		var inputValor = document
			.getElementById('nombre_producto')
			.value.trim()
			.toLowerCase()
		var productos = document.querySelectorAll('#productosContainer .col.mb-4')

		productos.forEach(function (producto) {
			var nombreProducto = producto
				.querySelector('.card-body .card-title')
				.innerText.trim()
				.toLowerCase()

			// Verificar si el nombre del producto contiene el valor de búsqueda
			if (nombreProducto.includes(inputValor)) {
				producto.style.display = 'block' // Mostrar el producto
			} else {
				producto.style.display = 'none' // Ocultar el producto si no coincide
			}
		})
	}

	// Función para limpiar la búsqueda y mostrar todos los productos
	function limpiarBusqueda() {
		var productos = document.querySelectorAll('#productosContainer .col.mb-4')

		productos.forEach(function (producto) {
			producto.style.display = 'block' // Mostrar todos los productos
		})

		document.getElementById('nombre_producto').value = '' // Limpiar el campo de búsqueda
	}

	// Evento para llamar a buscarProducto() cada vez que se presione una tecla en el campo de búsqueda
	document
		.getElementById('nombre_producto')
		.addEventListener('keyup', function () {
			buscarProducto()
		})
})
// descargar imagen archivos 3d//
document.addEventListener('DOMContentLoaded', function () {
	// Función para descargar la imagen
	function downloadImage(base64Data, filename) {
		var link = document.createElement('a')
		link.download = filename // Nombre del archivo a descargar
		link.href = base64Data // Datos en base64
		document.body.appendChild(link)
		link.click()
		document.body.removeChild(link)
	}

	// Evento de clic en el botón de descarga
	document
		.getElementById('modalDownloadButton')
		.addEventListener('click', function () {
			// Obtener la imagen codificada en base64 y el nombre del archivo
			var base64ImageData = document
				.getElementById('productoImagen')
				.getAttribute('src')
			var filename =
				document.getElementById('productoNombre').textContent.trim() + '.jpg'

			// Llamar a la función para descargar la imagen
			downloadImage(base64ImageData, filename)
		})

	// Ejemplo de carga de datos del producto (simulado)
	// Esto podría ser reemplazado por tu lógica para cargar los datos reales del producto
	document
		.getElementById('productoImagen')
		.setAttribute(
			'src',
			'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/...'
		) // Aquí va tu base64 completo

	// Ejemplo de carga de datos del producto (simulado)
	document.getElementById('productoNombre').textContent = 'Nombre del Producto'
	document.getElementById('productoDescripcion').textContent =
		'Descripción detallada del producto.'
})
//____________________________________________________________________________
function downloadImage(base64Data, filename) {
	// Convert base64 to blob
	const byteCharacters = atob(base64Data)
	const byteArrays = []
	for (let offset = 0; offset < byteCharacters.length; offset += 512) {
		const slice = byteCharacters.slice(offset, offset + 512)
		const byteNumbers = new Array(slice.length)
		for (let i = 0; i < slice.length; i++) {
			byteNumbers[i] = slice.charCodeAt(i)
		}
		const byteArray = new Uint8Array(byteNumbers)
		byteArrays.push(byteArray)
	}
	const blob = new Blob(byteArrays, { type: 'image/jpeg' })

	// Create download link
	const link = document.createElement('a')
	link.href = URL.createObjectURL(blob)
	link.download = filename
	document.body.appendChild(link)
	link.click()
	document.body.removeChild(link)
}
