<?php
session_start();
require 'config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_hashed = password_hash($contrasena, PASSWORD_BCRYPT);

    // Verificar si el correo ya está registrado
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();
    if ($stmt->fetch()) {
        $error = "Este correo ya está registrado.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (:nombre_usuario, :correo, :contrasena)");
        $stmt->bindParam(":nombre_usuario", $nombre_usuario);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":contrasena", $contrasena_hashed);

        if ($stmt->execute()) {
            $success = "Registro exitoso. Puedes <a href='login.php'>iniciar sesión aquí</a>.";
        } else {
            $error = "Hubo un error al registrarse. Inténtalo de nuevo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Agenda de Contactos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Registro</h2>
        <form action="registro.php" method="POST">
            <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="submit" value="Registrarse">
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>

        <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>.</p>
    </div>
</body>
</html>

