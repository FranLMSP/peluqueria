<template>
	<div>
		<div class="btn-wrapper">
			<router-link style="float:left;" to="/">Regresar</router-link>

			<router-link class="btn btn-primary btn-sm" to="/inventario/ingresar">Ingresar stock</router-link>
			<router-link class="btn btn-success btn-sm" to="/inventario/ventas">Ventas</router-link>
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Existencia</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!inventory || inventory.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="inv in inventory" :key="inv.id">
						<td>{{ inv.product.id }}</td>
						<td>{{ inv.product.name }}</td>
						<td>{{ inv.product.description }}</td>
						<td>{{ inv.existence }}</td>
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
				inventory: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.inventory = []
				axios('/api/inventory')
				.then( response => {
					this.inventory = response.data.inventory
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
				if (!this.inventory || this.inventory.length <= 0) {
					return 'Sin stock'
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