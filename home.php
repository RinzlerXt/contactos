<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$content = '
<h2 class="title">Bienvenido, ' . htmlspecialchars($_SESSION['nombre_usuario']) . '!</h2>
<p class="text_p">Nos alegra verte de nuevo en tu Agenda de Contactos. Desde aquí puedes acceder a tus contactos, actualizar los datos   o cerrar sesión cuando desees.</p>
';

include('layout.php');
