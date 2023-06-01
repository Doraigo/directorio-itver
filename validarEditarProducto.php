<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Configuración de AWS
$bucketName = 'directorio-itver'; // Reemplaza con el nombre de tu bucket en S3
$region = 'us-east-1'; // Reemplaza con la región de tu bucket en S3

$s3 = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'credentials' => [
        'key' => 'AKIAVX3DPKSKZGFF5KUT',
        'secret' => '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',
    ],
]);

// Iniciar la sesión
session_start();

// Verificar si no hay una sesión activa o si no se ha almacenado la información de usuario
if (!isset($_SESSION['username'])) {
    // Redireccionar al usuario a la página de inicio de sesión
    header("Location: login.html");
    exit;
}
// Obtener el idProducto del formulario
$idProducto = $_POST['id'];

// Verificar si se ha proporcionado el idProducto
if (empty($idProducto)) {
    echo "No se ha proporcionado el ID del producto.";
    exit;
}
// Verificar si se ha proporcionado el idProducto
if ($idProducto === null) {
    echo "No se ha proporcionado el ID del producto.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y validarlos
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_VALIDATE_INT);
    $categoriaId = filter_input(INPUT_POST, 'categoria', FILTER_VALIDATE_INT);

    // Validar los datos ingresados
    if (empty($nombre) || empty($precio) || empty($descripcion) || empty($telefono) || empty($categoriaId) || empty($idProducto)) {
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Validar el precio
    if ($precio === false || $precio < 0) {
        echo "Por favor, introduce un precio válido.";
        exit;
    }

    // Validar el teléfono
    if ($telefono === false || strlen((string) $telefono) !== 10) {
        echo "Por favor, introduce un número de teléfono válido (10 dígitos).";
        exit;
    }

    // Obtener información del archivo subido
    $nombreArchivo = $_FILES['imagen']['name'];
    $archivoTemporal = $_FILES['imagen']['tmp_name'];

    // Validar el archivo subido
    if (empty($nombreArchivo) || empty($archivoTemporal)) {
        echo "Por favor, selecciona una imagen.";
        exit;
    }

    // Ruta dentro del bucket donde se almacenará la imagen
    $carpeta = 'imagenes/';
    $rutaArchivo = $carpeta . $nombreArchivo;

    // Subir la imagen al bucket de S3
    try {
        $s3->putObject([
            'Bucket' => $bucketName,
            'Key' => $rutaArchivo,
            'SourceFile' => $archivoTemporal,
            'ACL' => 'public-read', // Hace que el objeto sea público
        ]);

        // Obtener la URL del archivo subido en S3
        $urlArchivo = $s3->getObjectUrl($bucketName, $rutaArchivo);

        // Actualizar los datos en la base de datos
        $mysqli = new mysqli("localhost", "root", "", "ItverAmarillo", 3306);

        // Verificar si hay error en la conexión
        if ($mysqli->connect_error) {
            die('Error de conexión: ' . $mysqli->connect_error);
        }

        // Consulta SQL con sentencia preparada
        $query = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, imagen = ?, telefono = ?, categoriaId = ? WHERE idProducto = ?";
        $statement = $mysqli->prepare($query);

        // Verificar si hay error en la preparación de la consulta
        if (!$statement) {
            die('Error en la consulta: ' . $mysqli->error);
        }

        // Vincular los parámetros a la consulta preparada
        $statement->bind_param("sisssii", $nombre, $precio, $descripcion, $urlArchivo, $telefono, $categoriaId, $idProducto);

        // Ejecutar la consulta
        $statement->execute();

        // Verificar si se actualizaron filas correctamente
        if ($statement->affected_rows > 0) {
            // Redireccionar a otra página o mostrar un mensaje de éxito
            header("Location: producto.php?id=" . $idProducto . "&success=true");
            exit;
        } else {
            echo "Error al actualizar los datos en la base de datos.";
        }

        // Cerrar la consulta y la conexión a la base de datos
        $statement->close();
        $mysqli->close();
    } catch (AwsException $e) {
        // Manejar cualquier error ocurrido durante la subida del archivo
        echo "Error al subir el archivo a S3: " . $e->getMessage();
    }
}
?>