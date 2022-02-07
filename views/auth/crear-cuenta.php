<h1 class="nombre-pagina">Crear cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form action="/crear-cuenta" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Tu nombre"
            value="<?php echo s($usuario->nombre); ?>"
        >
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input 
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Tu apellido"
            value="<?php echo s($usuario->apellido); ?>"
        >
    </div>
    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input 
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Tu teléfono"
            value="<?php echo s($usuario->telefono); ?>"
        >
    </div>
    <div class="campo">
        <label for="email">Correo:</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu correo electrónico"
            value="<?php echo s($usuario->email); ?>"
        >
    </div>
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu contraseña"
        >
    </div>
    <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
    <a href="/olvide">¿Olvidaste tu contraseña?</a>
</div>