<div class="container is-fluid mb-6">
    <h1 class="title">Categorías</h1>
    <h2 class="subtitle">Nueva categoría</h2>
</div>

<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/categoria_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label for="categoria_nombre">Nombre</label>
                    <input 
                        class="input" 
                        id="categoria_nombre"
                        type="text" 
                        name="categoria_nombre" 
                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" 
                        maxlength="50" 
                        required
                        placeholder="Introduce el nombre de la categoría"
                    >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label for="categoria_descripcion">Descripción</label>
                    <input 
                        class="input" 
                        id="categoria_descripcion"
                        type="text" 
                        name="categoria_descripcion" 
                        pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ.,- ]{5,150}" 
                        maxlength="150" 
                        placeholder="Introduce una descripción opcional"
                    >
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>
