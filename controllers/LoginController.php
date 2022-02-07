<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    //Iniciar sesión / index
    public static function login( Router $router){
        $alertas = [];
        $auth = new Usuario();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                // Comprobar que el usuario exista
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    //Verificar password
                    if($usuario->comprobarPasswordAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccionar
                        if($usuario->admin === "1"){
                            //Admin
                            $_SESSION['admin'] = $usuario->admin ?? NULL;
                            header('Location: /admin');
                        }else if($usuario->admin === "0"){
                            // CLiente
                            header('Location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error', 'Usario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    //Cerrar sesión
    public static function logout(){
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    //Recuperar contraseña
    public static function olvide( Router $router ){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    // Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    
                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de éxito
                    Usuario::setAlerta('exito', 'Revise su correo electrónico.');
                }else{
                    Usuario::setAlerta('error', 'El usuario no exite o no esta confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar( Router $router ){
        $alertas = [];

        $error = false;

        $token = s($_GET['token']);

        // Buscar usuario por el token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no válido.');
            $error = true;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer la nueva contraseña y guardarla
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = NULL;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = NULL;
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    //Crear cuenta
    public static function crearCuenta( Router $router ){
        $usuario = new Usuario;

        // Alertas vacías
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)){
                //Verificar si el usuario no este registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                }else{
                    // Hashear password
                    $usuario->hashPassword();

                    // Generar un token
                    $usuario->crearToken();
                    
                    // Enviar el Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function mensaje( Router $router){
        $router->render('auth/mensaje', []);
    }
    public static function confirmar(Router $router){
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // Mensaje error
            Usuario::setAlerta('error', 'Token no válido.');
        }else{
            // Modificar usuario a confirmado
            $usuario->confirmado = "1";
            $usuario->token = NULL;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}