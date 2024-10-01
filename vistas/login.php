<div class="main-container">
    <!-- Formulario de inicio de sesión -->
    <form class="box login" action="" method="POST" autocomplete="off">
        
        <!-- Logo centrado -->
        <div style="width: 100%; text-align: center;">
            <img src="./img/logo_inventario.png" width="200" height="50" alt="Logo" style="display: inline-block;">
        </div>
        <br>
        
        <!-- Campo para el usuario -->
        <div class="field">
            <label class="label" for="login_usuario">Usuario</label>
            <div class="control">
                <input 
                    class="input" 
                    id="login_usuario" 
                    type="text" 
                    name="login_usuario" 
                    pattern="[a-zA-Z0-9]{4,20}" 
                    maxlength="20" 
                    required 
                    aria-required="true" 
                    placeholder="Ingrese su usuario"
                >
            </div>
        </div>

        <!-- Campo para la clave -->
        <div class="field">
            <label class="label" for="login_clave">Clave</label>
            <div class="control">
                <input 
                    class="input" 
                    id="login_clave" 
                    type="password" 
                    name="login_clave" 
                    pattern="[a-zA-Z0-9$@.-]{4,100}" 
                    maxlength="100" 
                    required 
                    aria-required="true" 
                    placeholder="Ingrese su clave"
                >
            </div>
        </div>

        <!-- Botón para enviar el formulario -->
        <p class="has-text-centered mb-4 mt-3">
            <button 
                type="submit" 
                class="button is-info is-rounded"
                aria-label="Iniciar sesión"
            >
                Iniciar sesión
            </button>
        </p>

        <!-- Procesamiento del formulario en PHP -->
        <?php
            // Verificar si se enviaron los datos del formulario
            if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
                // Incluir archivos necesarios para el inicio de sesión
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
            }
        ?>
    </form>
</div>
