<?php
session_start();
require 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->bindParam(":correo", $correo);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user['contrasena'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['nombre_usuario'] = $user['nombre_usuario'];
        header("Location: home.php");
        exit();
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agenda de Contactos</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="login.php" method="POST">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <input type="submit" value="Ingresar">
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
    </div>
</body>
</html>
