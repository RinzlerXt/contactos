<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];

    try {
        $sql = "UPDATE contactos SET nombre = :nombre, telefono = :telefono, correo = :correo WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':id', $id);
        $usuario_id = $_SESSION['usuario_id'];
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Contacto actualizado exitosamente.";
            header("Location: ver_contactos.php");
            exit();
        } else {
            $mensaje = "Error al actualizar el contacto.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

$contacto = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $sql = "SELECT * FROM contactos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $usuario_id = $_SESSION['usuario_id'];
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$contacto) {
            $mensaje = "Contacto no encontrado.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

$content = '<h2 class="title">Editar Contacto</h2>';

if ($mensaje) {
    $content .= "<p>$mensaje</p>";
}

if ($contacto) {
    $content .= '
    <form action="editar_contacto.php" method="post">
        <input type="hidden" name="id" value="' . htmlspecialchars($contacto['id']) . '">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="' . htmlspecialchars($contacto['nombre']) . '" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="' . htmlspecialchars($contacto['telefono']) . '" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" value="' . htmlspecialchars($contacto['correo']) . '" required>

        <input type="submit" value="Actualizar Contacto">
    </form>';
}

include('layout.php');
?>
