<?php

// Para tener acceso a los libros toca abrir la caja fuerte
// El acceso es el archivo conexion_be.php hecho previamente
include 'conexion_be.php';

// Almacenamos en variables los datos ingresados en el formulario
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

    // Verificar que el correo electrónico sea válido
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || $correo[0] == '.' || substr($correo, -1) == '.') {
        echo '
            <script>
                alert("Por favor, ingresa un correo electrónico válido sin puntos al principio o al final");
                window.location = "../CRUD.php";
            </script>
        ';
        mysqli_close($conexion);
        exit();
    }

// Encryptando la contraseña
$contrasena = hash('sha512', $contrasena);

// Crear una query para que los datos guardados se guarden en la tabla 'usuarios'
$query = "INSERT INTO usuarios(nombre_completo, correo, usuario, ciudad_municipio, contrasena)
          VALUES('$nombre_completo', '$correo', '$usuario','$ciudad_municipio', '$contrasena')";  

// Verifiación de información no repetida
    // Verificar que el correo no se repita en la base de datos
    $verificar_correo = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' ");

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
    $verificar_usuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' ");

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

// Comando exit: Imprime un mensaje y termina el script actual

// Ya tenemos la llave, toca utilizarla (primer argumento)
// 2do argumento lo ejecuta como query
$ejecutar = mysqli_query($conexion, $query);

if( $ejecutar ){
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "../CRUD.php";
        </script>
    ';
}else{
    echo '
        <script>
            alert("Intentalo de nuevo, usuario no almacenado");
            window.location = "../CRUD.php";
        </script>
    ';
}

mysqli_close($conexion);
?>
