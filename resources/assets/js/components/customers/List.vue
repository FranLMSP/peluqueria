<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/clientes/crear">Crear</router-link>		
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Email</th>
					<th>Teléfono</th>
					<th>Website</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!customers || customers.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="customer in customers" :key="customer.id">
						<td>{{ customer.name }}</td>
						<td>{{ customer.email }}</td>
						<td>{{ customer.phone }}</td>
						<td>{{ customer.website }}</td>
						<td>
							<router-link :to="`/clientes/${customer.id}`">Detalles</router-link>
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
				customers: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.customers = []
				axios('/api/customers')
				.then( response => {
					this.customers = response.data.customers
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
				if (!this.customers || this.customers.length <= 0) {
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