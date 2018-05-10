<template>
	<div class="provider-show">
		<div class="sell-info">
			<table class="table">
				<tr>
					<th>ID</th>
					<td>{{ sell.id }}</td>
				</tr>
				<tr>
					<th>Cliente</th>
					<td>{{ sell.customer.names + ' ' + sell.customer.surnames }}</td>
				</tr>
				<tr>
					<th>Descripción</th>
					<td>{{ sell.description }}</td>
				</tr>
				<tr>
					<th>Productos</th>
					<td>
						<table class="table" style="width: 100%">
							<tr>
								<th>Producto</th>
								<th>Precio</th>
								<th>Cantidad</th>
								<th>Precio Total</th>
							</tr>

							<tr v-for="product in sell.products">
								<td>{{ product.product.definition.name }}</td>
								<td>{{ product.product.price }}</td>
								<td>{{ product.qty }}</td>
								<td>{{ product.qty * product.product.price }}</td>
							</tr>

							<tr>
								<td></td>
								<td></td>
								<td><strong>Total: </strong></td>
								<td>{{ totalPrice }}</td>
							</tr>

						</table>
					</td>
				</tr>
			</table>

			<router-link class="btn btn-primary" to="/inventario">Regresar</router-link>

			<br>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				sell: {
					id: 0,
					name: '',
					description: '',
					customer: {
						names: '',
						surnames: ''
					},
					products: []
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			},
			totalPrice() {
				let totals = 0

				for (let i = 0; i < this.sell.products.length ; i++) {
					totals += this.sell.products[i].qty * this.sell.products[i].product.price
				}

				return totals
			}
		},
		created() {
			axios.get(`/api/transactions/sales/${this.$route.params.id}`)
			.then( response => {
				this.sell = response.data.sell
			})
		}
	}
</script>

<style type="text/css">
	.provider-view {
		display: flex;
		align-items: center;
	}

	.user-img {
		flex: 1;
	}

	.user-img img {
		max-width: 160px
	}

	.sell-info {
		flex: 3;
		overflow-x: scroll;
	}
</style>