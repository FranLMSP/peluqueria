<template>
	<div class="customer-show">
		<div class="row">
			<div class="col-sm-12">
				
				<router-link :to="`/clientes/${customer.id}/editar`" class="btn btn-primary" style="float: right;">Editar</router-link>
			</div>		
		</div>

		<br>

		<div class="user-info">
			<table class="table">
				<tr>
					<th>ID</th>
					<td>{{ customer.id }}</td>
				</tr>
				<tr>
					<th>Nombres</th>
					<td>{{ customer.names }}</td>
				</tr>
				<tr>
					<th>Apellidos</th>
					<td>{{ customer.surnames }}</td>
				</tr>
				<tr>
					<th>Número de identidad</th>
					<td>{{ customer.identity_number }}</td>
				</tr>
				<tr>
					<th>Email</th>
					<td>{{ customer.email }}</td>
				</tr>
				<tr>
					<th>Teléfono</th>
					<td>{{ customer.phone }}</td>
				</tr>
				<tr>
					<th>Website</th>
					<td>{{ customer.birthdate }}</td>
				</tr>
			</table>

			<router-link class="btn btn-primary" to="/clientes">Regresar</router-link>

			<br>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				customer: {
					id: 0,
					name: '',
					email: '',
					phone: '',
					website: ''
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		created() {
			axios.get(`/api/customers/${this.$route.params.id}`)
			.then( response => {
				this.customer = response.data.customer
			})
		}
	}
</script>

<style type="text/css">
	.customer-view {
		display: flex;
		align-items: center;
	}

	.user-img {
		flex: 1;
	}

	.user-img img {
		max-width: 160px
	}

	.user-info {
		flex: 3;
		overflow-x: scroll;
	}
</style>