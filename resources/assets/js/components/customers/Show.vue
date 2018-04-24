<template>
	<div class="customer-show">
		<div class="user-img">
			<img src="">
		</div>

		<div class="user-info">
			<table class="table">
				<tr>
					<th>ID</th>
					<td>{{ customer.id }}</td>
				</tr>
				<tr>
					<th>Nombre</th>
					<td>{{ customer.name }}</td>
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
					<td>{{ customer.website }}</td>
				</tr>
			</table>

			<router-link to="/clientes">Regresar</router-link>
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