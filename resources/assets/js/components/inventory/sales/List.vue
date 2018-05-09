<template>
	<div>
		<div class="btn-wrapper">
			<router-link style="float: left;" to="/inventario">Regresar</router-link>			

			<router-link class="btn btn-primary btn-sm" to="/inventario/ventas/nueva">Nueva Venta</router-link>
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Cliente</th>
					<th>Fecha</th>
					<th>Detalles</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!sales || sales.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="sale in sales" :key="sale.id">
						<td>{{ sale.id }}</td>
						<td>{{ sale.customer.names + ' ' + sale.customer.surnames }}</td>
						<td>{{ sale.created_at }}</td>
						<td><router-link :to="`inventario/ventas/${sale.id}`">Ver</router-link></td>
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
				sales: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.sales = []
				axios('/api/transactions/sales')
				.then( response => {
					console.log(response.data)
					this.sales = response.data.sales
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
				if (!this.sales || this.sales.length <= 0) {
					return 'Sin ventas'
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