<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de configuración
include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario_id = $_SESSION['usuario_id']; // Obtener el ID del usuario desde la sesión

    try {
        // Insertar contacto en la base de datos usando una sentencia preparada
        $sql = "INSERT INTO contactos (nombre, telefono, correo, usuario_id) VALUES (:nombre, :telefono, :correo, :usuario_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':usuario_id', $usuario_id); // Vincular el usuario_id

        if ($stmt->execute()) {
            $mensaje = "Contacto creado exitosamente.";
        } else {
            $mensaje = "Error al crear el contacto.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

$content = '
<h2 class="title">Crear Contacto</h2>
<form action="crear_contacto.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" required>

    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" required>

    <input type="submit" value="Agregar Contacto">
</form>';

if (isset($mensaje)) {
    $content .= "<p>$mensaje</p>";
}

include('layout.php');
