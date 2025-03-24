<?php

    session_start();

    if(isset($_SESSION['usuario'])){
        header("location: bienvenida.php");
    }

?>


<!DOCTYPE hmtl>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Register - FeedTechSolution</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-x/Gxwti6W2OZMXgdHf1g9Po4GpsMTFVIWUXOvCxMBSwWevqXtWxlZWh9RJiq/H6mzqvo0l2VWxJDm8Eyt5LQw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head> 

<body>
    <!--Etiqueta main para tener control como proyecto--> 
    <main>
        <!--Creando contenedor-->
        <div class="contenedor__todo">

            <div class="caja__trasera">
                <!--Creando el cuadro de login de atrás-->
                <div class="caja__trasera-login">
                    <!--Texto de interrogación-->
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en tu cuenta</p> 
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <!--Texto de interrogación-->
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedes iniciar sensión</p> 
                    <button id="btn__registrarse">Registrarse</button>
                </div>
                <!--Hasta ahí hirían los 2 cuadritos en azul-->
            </div>

            <!--Ahora la caja blanca de formulario-->
            <div class="contenedor__login-register">
                <!--Formulario login-->
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">

                    <h2>Iniciar sesión</h2>
                    <input type="text" placeholder="Usuario" name="usuario">
                    <input type="password" placeholder="Contraseña" name="contrasena">
                    <a href="forgot_password.html">¿Olvidaste tu contraseña?</a>
                    <button>Entrar</button>

                </form>
                <!--Formulario registro-->
                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">

                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre completo" name="nombre_completo">
                    <input type="text" placeholder="Correo electronico" name="correo">
                    <!--<small>Del dominio de gmail</small>-->
                    <input type="text" placeholder="Usuario" name="usuario">
                    <input type="text" placeholder="Ciudad/Municipio" name="ciudad_municipio">
                        <div class="contenedor__password">
                            <input type="password" id="contrasena" placeholder="Contraseña" name="contrasena">
                            <span class="mostrar-contrasena" onclick="mostrarContrasena()">
                                <img src="assets/images/ojo_cerrado.png" alt="Ojo cerrado" id="icono-ojo" width="20" height="20"> <!-- Ícono de ojo cerrado -->
                            </span>
                        </div>
                    <small>Al menos una letra, un número o símbolo y mínimo 8 caracteres</small>
                    <button>Registrarse</button>

                </form>
            </div>

        </div>

    </main>
    <script src="assets/js/script.js"></script>

</body>
</html>