<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $usuario_id = $_SESSION['usuario_id'];

    if (!preg_match('/^(\d{3}-\d{3}-\d{4}|\d{10})$/', $telefono)) {
        $mensaje = "Error: El número de teléfono debe tener el formato 123-456-7890 o 1234567890.";
    } else {
        try {
            $sql = "INSERT INTO contactos (nombre, telefono, correo, usuario_id) VALUES (:nombre, :telefono, :correo, :usuario_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':usuario_id', $usuario_id);

            if ($stmt->execute()) {
                $mensaje = "Contacto creado exitosamente.";
            } else {
                $mensaje = "Error al crear el contacto.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    }
}

$content = '
<h2 class="title">Crear Contacto</h2>
<form action="crear_contacto.php" method="post">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" pattern="^(\d{3}-\d{3}-\d{4}|\d{10})$" title="Formato: 123-456-7890 o 1234567890" required>

    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" required>

    <input type="submit" value="Agregar Contacto">
</form>';

if (isset($mensaje)) {
    $content .= "<p class='message'>$mensaje</p>";
}

include('layout.php');
