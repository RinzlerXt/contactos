

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class>Agenda de Contactos</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/contactos.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="home.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="crear_contacto.php"><i class="fas fa-address-book"></i> Crear Contacto</a></li> <!-- Cambiar aquí -->
            <li><a href="ver_contactos.php">Contactos</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a></li>
        </ul>
    </nav>
        <main class="content">
            <h1 class="title">Agenda de Contactos</h1>
            <?php echo $content; ?>            
        </main>
    </div>

</body>
</html>
