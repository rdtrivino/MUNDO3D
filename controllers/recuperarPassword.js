function generarContrasenaTemporal() {
    // Definimos los caracteres posibles
    const mayusculas = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const minusculas = 'abcdefghijklmnopqrstuvwxyz';
    const numeros = '0123456789';
    const especiales = '@#$%&*';
    
    // Generamos una contraseña de 8 caracteres
    let contrasena = '';
    
    // Aseguramos que tenga una mayúscula
    contrasena += mayusculas.charAt(Math.floor(Math.random() * mayusculas.length));
    
    // Aseguramos que tenga un carácter especial
    contrasena += especiales.charAt(Math.floor(Math.random() * especiales.length));
    
    // Aseguramos que tenga un número
    contrasena += numeros.charAt(Math.floor(Math.random() * numeros.length));
    
    // Completamos con 5 caracteres aleatorios adicionales
    for(let i = 0; i < 5; i++) {
        const caracteresRestantes = minusculas + numeros;
        contrasena += caracteresRestantes.charAt(Math.floor(Math.random() * caracteresRestantes.length));
    }
    
    // Mezclamos los caracteres para que no sigan un patrón fijo
    return contrasena.split('').sort(() => Math.random() - 0.5).join('');
}

// Ejemplo de uso:
// const nuevaContrasena = generarContrasenaTemporal();
// console.log(nuevaContrasena); // Ejemplo output: "K@5nbpxt" 