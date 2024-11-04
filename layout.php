<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title class>Agenda de Contactos</title>
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/contactos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
        <h2>Menú</h2>
        <ul>
            <li><a href="crear_contacto.php"> Crear Contacto<i class="fa-solid fa-circle-plus"></i></a></li>
            <li><a href="ver_contactos.php">Contactos <i class="fa-regular fa-address-book"></i></a></li>
            <li><a href="logout.php">Cerrar sesión <i class="fas fa-sign-out-alt"></i></a></li>
        </ul>
    </nav>
        <main class="content">
        <h1 class="title"><i class="fas fa-address-book"></i> </h1>

            <?php echo $content; ?>            
        </main>
    </div>

</body>
</html>
