<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuación. </p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php"
?>

<?php if(!$error):?>
<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input 
            type="password"
            id="password"
            name="password"
            placeholder="Tu nueva contraseña"
        >
    </div>
    <input class="boton" type="submit" value="Cambiar contraseña">
</form>
<?php endif; ?>

<div class="acciones">
    <a href="/">Iniciar sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Obtener una</a>
</div>