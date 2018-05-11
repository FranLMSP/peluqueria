<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Bienvenido</div>

                <div class="card-body">
                    <ul>
                        <li><router-link to="/empleados">Empleados</router-link></li>
                        <li><router-link to="/clientes">Clientes</router-link></li>
                        <li><router-link to="/proveedores">Proveedores</router-link></li>
                        <li><router-link to="/productos">Productos</router-link></li>
                        <li><router-link to="/inventario">Inventario</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        name: 'home'
    }
</script>