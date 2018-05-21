<template>
	<div>
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12">
						<h3>Cumpleaños de los clientes</h3>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<table class="table" v-if="customers && customers.length > 0">
							<tr v-for="customer in customers">
								<p><strong>{{customer.names}} {{ customer.surnames }}</strong></p>
								<p>{{customer.identity_number}}</p>
								<p style="color: red"><strong>{{customer.birthdate | dateFormatText}}</strong></p>
							</tr>
						</table>
						<p v-else> {{ customersMessage }}</p>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12">
						<h3>Cumpleaños de los empleados</h3>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-12">
						<table class="table" v-if="employees && employees.length > 0">
							<tr v-for="employee in employees">
								<p><strong>{{employee.names}} {{ employee.surnames }}</strong></p>
								<p>{{employee.identity_number}}</p>
								<p><strong>{{employee.birthdate | dateFormatText}}</strong></p>
							</tr>
						</table>
						<p v-else> {{ employeesMessage }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

	export default {
		name: 'list',
		data() {
			return {
				customers: [],
				employees: [],
				loadingCustomers: false,
				loadingEmployees: false,
			}
		},
		methods: {
			get() {
				this.loadingCustomers = true
				this.customers = []
				axios('/api/customers/birthdays')
				.then( response => {
					this.customers = response.data.customers
					this.loadingCustomers = false
				})
				.catch( error => {
					alert('Ocurrió un error al listar los clientes')
				})
				.then( () => {
					this.loadingCustomers = false
				})

				this.loadingEmployees = true
				this.employees = []
				axios('/api/employees/birthdays')
				.then( response => {
					this.employees = response.data.employees
					this.loadingEmployees = false
				})
				.catch( error => {
					alert('Ocurrió un error al listar los empleados')
				})
				.then( () => {
					this.loadingEmployees = false
				})

			},

		},
		filters: {
			dateFormatText(date) {
				let dateText = new Date(date).toLocaleDateString("es-ES", {
					weekday: 'long',
					month: 'long',
					day: 'numeric'
				})
				/*let dayOfWeek = new Date(date).getDay()    
				let weekDay = isNaN(dayOfWeek) ? null : [
					'Lunes',
					'Martes',
					'Miercoles',
					'Jueves',
					'Viernes',
					'Sábado',
					'Domingo']
					[dayOfWeek]*/

				return dateText
			}
		},
		computed: {
			customersMessage() {
				if (this.loadingCustomers) {
					return 'Cargando...'
				}
				if (!this.customers || this.customers.length <= 0) {
					return 'Ningún cliente cumple año esta semana'
				}
				return ''
			},
			employeesMessage() {
				if (this.loadingEmployees) {
					return 'Cargando...'
				}
				if (!this.employees || this.employees.length <= 0) {
					return 'Ningún empleado cumple año esta semana'
				}
				return ''				
			}
		},
		created() {
			this.get()
		}
	}
</script>

<style type="text/css">
	.btn-wrapper {
		text-align: right;
		margin-bottom: 20px;
	}
</style>