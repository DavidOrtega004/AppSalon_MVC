<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Restablece tu contraseña escribiendo tu correo electrónico a continuación</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<form action="/olvide" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Correo:</label>
        <input 
            type="email"
            id="email"
            name="email"
            placeholder="Tu correo electrónico"
        >
    </div>
    <input type="submit" value="Enviar instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/">¿Ya tienes una cuenta? Iniciar sesión</a>
</div>