<?php

    session_start();

    include 'conexion_be.php';

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Por favor debes inicar sesión");
                window.location = "CRUD.php";
            </script>
        ';
        session_destroy();
        die();
    }

    $identificacion = $_SESSION['usuario'];
    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $ciudad_municipio = $_POST['ciudad_municipio'];
    $contrasena = $_POST['contrasena'];

    // Verificación de datos registrados

        // Verificar que el nombre tenga al menos 8 carácteres        
        if (strlen($nombre_completo) < 8) {
            echo '
                <script>
                    alert("El nombre debe tener al menos 8 caracteres");
                    window.location = "../CRUD.php";
                </script>
            ';
            mysqli_close($conexion);
            exit(); 
        }

        // Verificar que la contraseña sea segura, Que tenga al menos una letra, un número o un símbolo, y al menos 8 caracteres        
        if (!preg_match("/^(?=.*[A-Za-z])(?=.*[\d@$!%*#?&_])[A-Za-z\d@$!%*#?&_]{8,}$/", $contrasena)) {
            echo '
                <script>
                    alert("¡RECUERDA!. La contraseña debe tener al menos una letra, un número o un símbolo, y al menos 8 caracteres");
                    window.location = "../CRUD.php";
                </script>
            ';
            mysqli_close($conexion);
            exit(); 
        }

        // Verificar que el correo electrónico sea válido, tenga el dominio "@gmail.com" y no tenga un punto al principio o al final
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || strpos($correo, '@gmail.com') === false || $correo[0] == '.' || substr($correo, -1) == '.') {
            echo '
                <script>
                    alert("Por favor, ingresa un correo electrónico válido con el dominio @gmail.com sin puntos al principio o al final");
                    window.location = "../CRUD.php";
                </script>
            ';
            mysqli_close($conexion);
            exit();
        }

    
    // Encryptando la contraseña
    $contrasena = hash('sha512', $contrasena);

    // Verifiación de información no repetida
        // Verificar que el correo no se repita en la base de datos
        $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' AND usuario != '$identificacion'");

        if( mysqli_num_rows($verificar_correo) > 0){
            echo '
                <script>
                    alert("Este correo ya está registrado, intenta con otro diferente");
                    window.location = "../CRUD.php";
                </script>
            ';
            mysqli_close($conexion);
            exit();
        }

        // Verificar que el usuario no se repita en la base de datos
        $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND usuario != '$identificacion'");

        if( mysqli_num_rows($verificar_usuario) > 0){
            echo '
                <script>
                    alert("Este usuario ya está registrado, intenta con otro diferente");
                    window.location = "../CRUD.php";
                </script>
            ';
            mysqli_close($conexion);
            exit();
        }


    // Actualizar datos de la bd
    $validar_actualizacion = mysqli_query($conexion, "UPDATE usuarios SET nombre_completo='$nombre_completo', correo='$correo', usuario='$usuario', ciudad_municipio='$ciudad_municipio', contrasena='$contrasena'
    WHERE usuario = '$identificacion'");
    


    if( $validar_actualizacion ){
        echo '
            <script>
                alert("¡La cuenta ha sido actualizada con exito!");
                window.location = "../CRUD.php"; // Redirigir a la página principal
            </script>
        ';
        session_destroy();
        exit;
    }else{
        echo '
            <script>
                alert("Ha habido un problema, vuelve a intentarlo");
                window.location = "../modificar_cuenta.php"; // Redirigir a la página de modificación
            </script>
        ';
    }

?>