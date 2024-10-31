<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de configuración
include('config.php');

// Inicializar el mensaje
$mensaje = "";

// Manejar la eliminación de un contacto
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

// Manejar la búsqueda de contactos
$busqueda = "";
if (isset($_POST['buscar'])) {
    $busqueda = $_POST['buscar'];
}

// Obtener la lista de contactos
try {
    $sql = "SELECT * FROM contactos WHERE usuario_id = :usuario_id AND (nombre LIKE :busqueda OR telefono LIKE :busqueda OR correo LIKE :busqueda) ORDER BY nombre ASC";
    $stmt = $pdo->prepare($sql);
    $usuario_id = $_SESSION['usuario_id'];
    $busqueda_param = "%" . $busqueda . "%"; // Para la búsqueda con LIKE
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':busqueda', $busqueda_param);
    $stmt->execute();

    $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensaje = "Error: " . $e->getMessage();
}

// Definir el contenido para ser incluido en layout.php
$content = '
<h2>Lista de Contactos</h2>
<form action="ver_contactos.php" method="post">
    <input type="text" name="buscar" value="' . htmlspecialchars($busqueda) . '" placeholder="Buscar contacto...">
    <input type="submit" value="Buscar">
</form>';

if (isset($mensaje)) {
    $content .= "<p>$mensaje</p>";
}

if (count($contactos) > 0) {
    $content .= '<table>
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
                <a href="editar_contacto.php?id=' . $contacto['id'] . '">Editar</a>
                <a href="ver_contactos.php?eliminar=' . $contacto['id'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este contacto?\');">Eliminar</a>
            </td>
        </tr>';
    }
    
    $content .= '</table>';
} else {
    $content .= '<p>No se encontraron contactos.</p>';
}

include('layout.php');
