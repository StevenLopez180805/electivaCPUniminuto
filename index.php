<?php
/**
 *  Este codigo hace parte de la primera actividad de la unidad uno del curso de 'Electiva CP'
 *  
 *  @author Jeisson Steven Lopez Lopez <jeisson.lopez-l@uniminuto.edu.co>
 */

/**
  * 
  * Funcion que encripta un determinado mensaje segun una llave
  * @param string $mensaje Mensaje a encriptar
  * @param string $llave llave con la que se encriptara
  * @return string Mensaje encriptado
  */
function encriptarMensaje(string $mensaje, string $llave):string {
    $metodo = 'AES-256-CBC';
    $vector = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));
    $encrypted = openssl_encrypt($mensaje, $metodo, $llave, 0, $vector);
    return base64_encode($vector . $encrypted);
}

/**
  * 
  * Funcion que desencripta un determinado mensaje segun una llave
  * @param string $mensaje Mensaje a desencriptar
  * @param string $llave llave con la que se desencriptara
  * @return string Mensaje desencriptado
  */
function desencriptarMensaje(string $mensajeEncriptado, string $llave):string {
    $metodo = 'AES-256-CBC';
    $data = base64_decode($mensajeEncriptado);
    $vectorLength = openssl_cipher_iv_length($metodo);
    $vector = substr($data, 0, $vectorLength);
    $textoCifrado = substr($data, $vectorLength);
    $mensaje = openssl_decrypt($textoCifrado, $metodo, $llave, 0, $vector);
    return $mensaje;
}

if ($argc !== 4) {
    echo "El modo de uso es: php script.php {encriptar|desencriptar} <llave> <mensaje>\n";
    exit;
}

$operacion = $argv[1];
$llave = $argv[2];
$mensaje = $argv[3];

if ($operacion === "encriptar") {
    $respuesta = encriptarMensaje($mensaje, $llave);
    echo "Mensaje encriptado:\n$respuesta\n";
} elseif ($operacion === "desencriptar") {
    $respuesta = desencriptarMensaje($mensaje, $llave);
    echo "Mensaje desencriptado:\n$respuesta\n";
} else {
    echo "Operación no válida.\n";
    exit;
}