<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    http_response_code(403); // Código de respuesta 403 Forbidden
    exit("Acceso denegado. No tienes los permisos necesarios para eliminar un producto.");
}

$idProducto = $_POST['idProducto'] ?? 0;

if (!is_numeric($idProducto)) {
    http_response_code(400); // Código de respuesta 400 Bad Request
    exit("ID de producto inválido.");
}

error_log("Valor de idProducto: " . $idProducto); // Imprimir el valor en el registro de errores // Verificar el valor del ID del producto

$conexion = new mysqli('localhost', 'root', '', 'ItverAmarillo');
if ($conexion->connect_error) {
    http_response_code(500); // Código de respuesta 500 Internal Server Error
    exit("Error de conexión a la base de datos: " . $conexion->connect_error);
}

$sql = "DELETE FROM productos WHERE idProducto = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Código de respuesta 500 Internal Server Error
    exit("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("i", $idProducto);

if ($stmt->execute()) {
    http_response_code(200); // Código de respuesta 200 OK
    exit("Producto eliminado correctamente.");
} else {
    http_response_code(500); // Código de respuesta 500 Internal Server Error
    exit("Error al intentar eliminar el producto: " . $stmt->error);
}

$stmt->close();
$conexion->close();
?>
