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
						<td colspan="4" class="text-center">Sin clientes</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="customer in customers" :key="customer.id">
						<td>{{ customer.name }}</td>
						<td>{{ customer.email }}</td>
						<td>{{ customer.phone }}</td>
						<td>{{ customer.website }}</td>
						<td>
							<router-link to="`/clientes/${costumer.id}`">Detalles</router-link>
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
		computed: {
			customers() {
				return this.$store.getters.customers
			}
		},
		mounted() {
			this.$store.dispatch('getCustomers')
		}
	}
</script>

<style type="text/css">
	.btn-wrapper {
		text-align: right;
		margin-bottom: 20px;
	}
</style>