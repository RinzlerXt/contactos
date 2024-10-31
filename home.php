<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$content = '
<h2>Bienvenido, ' . htmlspecialchars($_SESSION['nombre_usuario']) . '!</h2>
<p>Nos alegra verte de nuevo en tu Agenda de Contactos. Desde aquí puedes acceder a tus contactos, actualizar tu perfil o cerrar sesión cuando desees.</p>
';

include('layout.php');
