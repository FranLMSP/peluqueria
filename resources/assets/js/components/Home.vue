<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">

                <div class="card-header">Bienvenido</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <router-link to="/celebraciones" class="btn btn-primary">Cumpleañeros <span class="badge" style="background-color: white" :style="customerBirthdates > 0 ? 'color: red' : 'color: black'">Clientes: {{ customerBirthdates }}</span> <span class="badge" style="background-color: white" :style="employeeBirthdates > 0 ? 'color: red' : 'color: black'">Empleados {{ employeeBirthdates }}</span></router-link>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-sm-12">
                            <ul>
                                <li><router-link to="/empleados">Empleados</router-link></li>
                                <li><router-link to="/clientes">Clientes</router-link></li>
                                <li><router-link to="/proveedores">Proveedores</router-link></li>
                                <li><router-link to="/productos">Productos</router-link></li>
                                <li><router-link to="/inventario">Inventario</router-link></li>
                                <li><router-link to="/comisiones">Comisiones</router-link></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default {
        name: 'home',
        data() {
            return {
                customerBirthdates: '',
                employeeBirthdates: '',
            }
        },
        created() {
            axios.get('/api/customers/birthdays')
            .then( response => {
                this.customerBirthdates = response.data.customers.length
            })
            .catch( error => {
                console.log(error.status);
                if(error.status != 401)
                    alert('Ocurrió un error al obtener los cumpleañeros de la semana');
            })

            axios.get('/api/employees/birthdays')
            .then( response => {
                this.employeeBirthdates = response.data.employees.length
            })
            .catch( error => {
                console.log(error.status);
                if(error.status != 401)
                    alert('Ocurrió un error al obtener los cumpleañeros de la semana');
            })
        }
    }
</script>