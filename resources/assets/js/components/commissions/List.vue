<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/comisiones/crear">Crear</router-link>		
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
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
					<tr v-for="commission in commissions" :key="commission.id">
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
				commissions: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.commissions = []
				axios('/api/commissions')
				.then( response => {
					console.log(response.data)
					this.commissions = response.data.commissions
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
				if (!this.commissions || this.commissions.length <= 0) {
					return 'Sin comisiones'
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