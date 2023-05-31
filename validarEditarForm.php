<?php
// ValidarEditarForm.php

// Obtener el ID del producto a editar
$product_id = $_GET['id'];

// Conexión a la base de datos
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ItverAmarillo';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos existentes del producto
$sql = "SELECT * FROM productos WHERE id = $product_id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

// Verificar si el formulario fue enviado para actualizar los datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los nuevos valores del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $telefono = $_POST['telefono'];
    $imagen = $_FILES['imagen']['name'];
    $categoria = $_POST['categoria'];

    // Validar los datos utilizando regex
    $errors = array();

    // Validar nombre (solo letras y espacios)
    if (!preg_match('/^[A-Za-z\s]+$/', $nombre)) {
        $errors[] = "El nombre solo puede contener letras y espacios.";
    }

    // Validar precio (número decimal positivo)
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $precio)) {
        $errors[] = "El precio debe ser un número decimal positivo.";
    }

    // Validar descripción (cualquier texto)
    if (empty($descripcion)) {
        $errors[] = "La descripción no puede estar vacía.";
    }

    // Validar teléfono (10 dígitos numéricos)
    if (!preg_match('/^\d{10}$/', $telefono)) {
        $errors[] = "El teléfono debe tener 10 dígitos.";
    }

    // Validar imagen (opcional: extensión y tamaño máximo)
    if (!empty($imagen)) {
        $allowed_extensions = array('jpg', 'jpeg', 'png');
        $max_file_size = 2 * 1024 * 1024; // 2MB

        $file_extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            $errors[] = "La imagen debe tener una extensión JPG, JPEG o PNG.";
        }

        if ($_FILES['imagen']['size'] > $max_file_size) {
            $errors[] = "La imagen debe tener un tamaño máximo de 2MB.";
        }
    }

    // Si no hay errores de validación, actualizar los datos en la base de datos
    if (empty($errors)) {
        // Actualizar los datos en la base de datos
        $sql = "UPDATE productos SET nombre = '$nombre', precio = '$precio', descripcion = '$descripcion', telefono = '$telefono', categoria = '$categoria' WHERE id = $product_id";

        if ($conn->query($sql) === TRUE) {
            echo "Los datos del producto han sido actualizados correctamente.";
        } else {
            echo "Error al actualizar los datos: " . $conn->error;
        }
    } else {
        // Mostrar errores de validación al usuario
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
