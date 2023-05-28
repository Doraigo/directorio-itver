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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $categoriaId = $_POST['categoria']; // Aquí se obtiene el ID de la categoría seleccionada

    // Obtener información del archivo subido
    $nombreArchivo = $_FILES['imagen']['name'];
    $archivoTemporal = $_FILES['imagen']['tmp_name'];

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

        // Guardar los demás datos y la URL del archivo en la base de datos
        $test = "1";
        $mysql = new mysqli("localhost", "root", "", "ItverAmarillo", 3306);
        $query = "INSERT INTO productos (nombre, precio, descripcion, imagen, usuarioId, categoriaId) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $mysql->prepare($query);
        $statement->bind_param("sissis", $nombre, $precio, $descripcion, $urlArchivo, $test, $categoriaId);
        $statement->execute();

        // Redireccionar a otra página o mostrar un mensaje de éxito
        header("Location: form.php");
        exit();
    } catch (AwsException $e) {
        // Manejar cualquier error ocurrido durante la subida del archivo
        echo "Error al subir el archivo a S3: " . $e->getMessage();
    }
}
?>
