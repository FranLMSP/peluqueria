<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/empleados/crear">Crear</router-link>		
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>Nombres</th>
					<th>Apellidos</th>
					<th>Identidad</th>
					<th>Cargo</th>
					<th>Email</th>
					<th>Teléfono</th>
					<th>Fecha de nacimiento</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!employees || employees.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="employee in employees" :key="employee.id">
						<td>{{ employee.names }}</td>
						<td>{{ employee.surnames }}</td>
						<td>{{ employee.identity_number }}</td>
						<td>{{ employee.occupation.name }}</td>
						<td>{{ employee.email }}</td>
						<td>{{ employee.phone }}</td>
						<td>{{ employee.birthdate }}</td>
						<td>
							<router-link :to="`/empleados/${employee.id}`">Detalles</router-link>
						</td>
					</tr>
				</template>
			</tbody>
		</table>
	</div>
</template>

<script type="text/javascript">

	export default {
		name: 'list',
		data() {
			return {
				employees: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.employees = []
				axios('/api/employees')
				.then( response => {
					this.employees = response.data.employees
					this.loading = false
				})
				.catch( error => {
					this.loading = false
				})

			}
		},
		computed: {
			tableMessage() {
				if (this.loading) {
					return 'Cargando...'
				}
				if (!this.employees || this.employees.length <= 0) {
					return 'Sin clientes'
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