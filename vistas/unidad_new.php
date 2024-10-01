<div class="container is-fluid mb-6">
    <h1 class="title">Productos Unidad</h1>
    <h2 class="subtitle">Nueva unidad</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/unidad_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Producto</label>
                    <div class="select is-fullwidth">
                        <select name="producto_id" required>
                            <option value="" disabled selected>Seleccionar producto</option>
                            <?php
                                // Conexión a la base de datos
                                $productos = conexion();
                                $productos = $productos->query("SELECT producto_id, producto_nombre FROM producto");
                                if ($productos->rowCount() > 0) {
                                    $productos = $productos->fetchAll();
                                    foreach ($productos as $row) {
                                        echo '<option value="'.$row['producto_id'].'">'.$row['producto_nombre'].'</option>';
                                    }
                                }
                                $productos = null;
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Estado</label>
                    <div class="select is-fullwidth">
                        <select name="estado_producto" required>
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="Disponible">Disponible</option>
                            <option value="En mantenimiento">En mantenimiento</option>
                            <option value="En proyecto">En proyecto</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Fallas</label>
                    <input class="input" type="text" name="fallas" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,255}" maxlength="255" required>
                </div>
            </div>
        </div>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
