<?php

define('SECRET_KEY', 'tu_clave_secreta_aqui');
define('SECRET_IV', 'tu_clave_iv_secreta_aqui');
define('METHOD', 'el_metodo_de_cifrado_aqui');

function decryption($string){
    $key = hash('sha256', SECRET_KEY);
    $iv = substr(hash('sha256', SECRET_IV), 0, 16);
    $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
    return $output;
}

$texto_cifrado = 'K1hvdkhOR2hvQ1pzK2V1STJPaGlwQT09';
$texto_descifrado = decryption($texto_cifrado);

echo "Texto descifrado: $texto_descifrado";

?>
