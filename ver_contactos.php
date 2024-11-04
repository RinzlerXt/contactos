<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include('config.php');

$mensaje = '';

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    try {
        $sql = "DELETE FROM contactos WHERE id = :id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $usuario_id = $_SESSION['usuario_id'];
        $stmt->bindParam(':usuario_id', $usuario_id);

        if ($stmt->execute()) {
            $mensaje = "Contacto eliminado exitosamente.";
        } else {
            $mensaje = "Error al eliminar el contacto.";
        }
    } catch (PDOException $e) {
        $mensaje = "Error: " . $e->getMessage();
    }
}

$busqueda = "";
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['buscar'];
}

try {
    $sql = "SELECT * FROM contactos WHERE usuario_id = :usuario_id AND (nombre LIKE :busqueda OR telefono LIKE :busqueda OR correo LIKE :busqueda) ORDER BY nombre ASC";
    $stmt = $pdo->prepare($sql);
    $usuario_id = $_SESSION['usuario_id'];
    $busqueda_param = "%" . $busqueda . "%";
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':busqueda', $busqueda_param);
    $stmt->execute();

    $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje = "Error: " . $e->getMessage();
}

$content = '
<h2 class="title">Lista de Contactos</h2>
<form action="ver_contactos.php" method="post">
    <input type="text" name="buscar" value="' . htmlspecialchars($busqueda) . '" placeholder="Buscar contacto...">
    <input type="submit" value="Buscar">
</form>';

if ($mensaje) {
    $content .= "<p class='message'>$mensaje</p>";
}

if (count($contactos) > 0) {
    $content .= '<div class="contact-table"><table>
        <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo Electrónico</th>
            <th>Acciones</th>
        </tr>';
    
    foreach ($contactos as $contacto) {
        $content .= '<tr>
            <td>' . htmlspecialchars($contacto['nombre']) . '</td>
            <td>' . htmlspecialchars($contacto['telefono']) . '</td>
            <td>' . htmlspecialchars($contacto['correo']) . '</td>
            <td>
                <a href="editar_contacto.php?id=' . $contacto['id'] . '" class="btn edit">Editar</a>
                <a href="ver_contactos.php?eliminar=' . $contacto['id'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este contacto?\');" class="btn delete">Eliminar</a>
            </td>
        </tr>';
    }
    
    $content .= '</table></div>';
} else {
    $content .= '<p class="no-contact">No se encontraron contactos.</p>';
}

include('layout.php');
?>
