<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Conexión a la base de datos
    $conn = new mysqli('sql106.infinityfree.com', 'if0_36284776', 'Vacas2024', 'if0_36284776_password_resets');
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar que el token es válido
    $sql = "SELECT * FROM password_resets WHERE token=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Actualizar la contraseña
        $sql = "UPDATE users SET password=? WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        // Eliminar el token de restablecimiento
        $sql = "DELETE FROM password_resets WHERE token=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "Tu contraseña ha sido restablecida.";
    } else {
        echo "Token inválido o expirado.";
    }

    $stmt->close();
    $conn->close();
}
?>
