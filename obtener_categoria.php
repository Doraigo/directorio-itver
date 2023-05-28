<?php
// Conexión a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'itveramarillo');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta para obtener las categorías
$sql = "SELECT idCategoria, nombreCategoria FROM categorias";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo '<option value="' . $fila["idCategoria"] . '">' . $fila["nombreCategoria"] . '</option>';
    }
} else {
    echo "No se encontraron categorías.";
}

// Cerrar la conexión
$conexion->close();


?>
