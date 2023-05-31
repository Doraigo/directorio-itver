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
$idProducto = $_GET['id'];

// Verificar si se ha proporcionado el idProducto
if (empty($idProducto)) {
    echo "No se ha proporcionado el ID del producto.";
    exit;
}

// Eliminar el producto de la base de datos
$mysqli = new mysqli("localhost", "root", "", "ItverAmarillo", 3306);

// Verificar si hay error en la conexión
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

// Consulta SQL para obtener los datos del producto
$query = "SELECT * FROM productos WHERE idProducto = ?";
$statement = $mysqli->prepare($query);

// Verificar si hay error en la preparación de la consulta
if (!$statement) {
    die('Error en la consulta: ' . $mysqli->error);
}

// Vincular el parámetro a la consulta preparada
$statement->bind_param("i", $idProducto);

// Ejecutar la consulta
$statement->execute();

// Obtener los resultados de la consulta
$result = $statement->get_result();

// Verificar si se encontró el producto
if ($result->num_rows === 0) {
    echo "El producto no existe.";
    exit;
}

// Obtener los datos del producto
$row = $result->fetch_assoc();
$imagenKey = $row['imagen'];

// Eliminar la imagen del producto de S3
try {
    $s3->deleteObject([
        'Bucket' => $bucketName,
        'Key' => $imagenKey
    ]);
} catch (AwsException $e) {
    echo "Error al eliminar la imagen del producto de S3: " . $e->getMessage();
    exit;
}

// Cerrar la consulta
$statement->close();

// Eliminar todos los datos relacionados con el idProducto
$deleteQuery = "DELETE FROM productos WHERE idProducto = ?";
$deleteStatement = $mysqli->prepare($deleteQuery);
$deleteStatement->bind_param("i", $idProducto);
$deleteStatement->execute();

// Verificar si se eliminó el producto correctamente
if ($deleteStatement->affected_rows > 0) {
    // Redireccionar a otra página o mostrar un mensaje de éxito
    header("Location: producto.php?success=true");
    exit;
} else {
    echo "Error al eliminar el producto de la base de datos.";
}

// Cerrar la conexión a la base de datos
$deleteStatement->close();
$mysqli->close();

?>