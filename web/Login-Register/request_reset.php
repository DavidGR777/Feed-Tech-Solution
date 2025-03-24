<?php
// Incluir la conexión a la base de datos
include 'php/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verificar que el email existe en la tabla `usuarios`
    $sql = "SELECT * FROM usuarios WHERE correo=?";
    $stmt = $conexion->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conexion->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generar un token
        $token = bin2hex(random_bytes(50));

        // Insertar el token en la tabla `password_resets` de la base de datos correcta
        $sql = "INSERT INTO if0_36284776_password_resets.password_resets (email, token) VALUES (?, ?)";
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conexion->error);
        }
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        // Enviar el correo electrónico con el enlace de restablecimiento
        $reset_link = "http://yourdomain.com/reset_password.php?token=" . $token;
        $subject = "Restablecimiento de Contraseña";
        $message = "Haz clic en el siguiente enlace para restablecer tu contraseña: " . $reset_link;
        $headers = "From: no-reply@yourdomain.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "Revisa tu correo electrónico para restablecer tu contraseña.";
        } else {
            echo "Error al enviar el correo electrónico.";
        }
    } else {
        echo "Correo electrónico no registrado.";
    }

    $stmt->close();
    // No necesitas cerrar la conexión aquí
}
?>
