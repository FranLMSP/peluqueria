<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/comisiones/crear">Crear</router-link>		
			<a class="btn btn-warning btn-sm" href="#">Editar seleccionados</a>		
		</div>
		
		<div class="row">
			<div class="col-sm-4 offset-sm-4">
				<label>Servicios</label>
				<select class="form-control" v-model="service">
					<option value="A" selected>Todos</option>
					<option v-for="service in services" :value="service.id">
						{{ service.name }}
					</option>
				</select>
			</div>
			<div class="col-sm-4">
				<label>Empleados</label>
				<select class="form-control" v-model="employee">
					<option value="A" selected>Todos</option>
					<option v-for="employee in employees" :value="employee.id">
						{{ employee.names + ' ' + employee.surnames }}
					</option>
				</select>				
			</div>
		</div>

		<br>

		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th><input type="checkbox" @change="selectAll">Seleccionar</th>
					<th>Servicio</th>
					<th>Empleado</th>
					<th>Comisión</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!commissions || commissions.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="(commission,index) in commissions" :key="commission.id">
						<td><input type="checkbox" v-model="selected[index]" :value="commission.id"></td>
						<td>{{ commission.service.definition.name }}</td>
						<td>{{ commission.employee.names + ' ' + commission.employee.surnames }}</td>
						<td>{{ commission.percentage + '%' }}</td>
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
				commissionsList: [],
				service: 'A',
				employee: 'A',
				selected: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.commissionsList = []
				axios('/api/commissions')
				.then( response => {
					console.log(response.data)
					this.commissionsList = response.data.commissions
					this.loading = false
				})
				.catch( error => {
					this.loading = false
				})

			},
			selectAll() {
				this.selected = []
				for (let i = 0; i<this.commissions.length; i++) {
					this.selected[i] = this.commissions.id
				}
			},
			exists(id, array) {
				for(let i = 0; i < array.length; i++) {
					if(array[i].id == id)
						return true
				}

				return false
			}
		},
		computed: {
			tableMessage() {
				if (this.loading) {
					return 'Cargando...'
				}
				if (!this.commissionsList || this.commissionsList.length <= 0) {
					return 'Sin comisiones'
				}
				return ''
			},
			services() {
				let services = []
				for(let i = 0; i < this.commissionsList.length ; i++) {
					if(!this.exists(this.commissionsList[i].service.definition.id, services)) {
						
						services.push({
							id: this.commissionsList[i].service.definition.id,
							name: this.commissionsList[i].service.definition.name
						})
					}
				}

				return services;
			},
			employees() {
				let employees = []
				for(let i = 0; i < this.commissionsList.length ; i++) {
					if(!this.exists(this.commissionsList[i].employee.id, employees)) {

						employees.push({
							id: this.commissionsList[i].employee.id,
							names: this.commissionsList[i].employee.names,
							surnames: this.commissionsList[i].employee.surnames
						})
					}
				}

				return employees
			},
			commissions() {

				let commissions = []

				for(let i = 0; i<this.commissionsList.length; i++) {
					if((this.service === 'A' || this.service == this.commissionsList[i].service.definition.id ) &&
					(this.employee === 'A' || this.employee == this.commissionsList[i].employee.id )  ) {
						commissions.push(this.commissionsList[i])
					}
				}

				return commissions
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