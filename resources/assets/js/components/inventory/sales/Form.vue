<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="customer-new">
			<form @submit.prevent="save">
				<table class="table">
					<tr>
						<th>Cliente</th>
						<td>
							<div class="form-group">
								<select class="form-control" v-model="form.customer" :data-selected="form.customer">
									<option :selected="customer.id == form.customer ? 'selected' : ''" v-for="customer in customers" :value="customer.id">{{ customer.names + ' ' + customer.surnames }}</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Productos</th>
						<td>
							<div v-for="formProduct in form.products">
								<div class="row">
									<div class="col-sm-6">
										<select class="form-control" v-model="formProduct.id" :data-selected="formProduct.id">
											<option :selected="product.id == formProduct.id ? 'selected':''" v-for="(product,indexProd) in products" :value="product.id">{{ product.definition.name }}</option>
										</select>
									</div>
									<div class="col-sm-4">
										<input class="form-control" type="number" v-model="formProduct.qty" placeholder="Cantidad">
									</div>
									<div class="col-sm-1">
										<button class="btn" :class="form.products.length <= 1 ? 'btn-default' : 'btn-danger'" @click.prevent="removeProduct(index)">&times;</button>
									</div>
									<div class="col-sm-1">
										<button class="btn btn-success" @click.prevent="addProduct">&plus;</button>
									</div>
								</div>
								<br>
							</div>
						</td>
					</tr>
					<tr>
						<th>Detalles adicionales</th>
						<td>
							<textarea class="form-control" v-model="form.description" placeholder="Detalles"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<router-link to="/inventario/ventas" class="btn btn-default">Regresar</router-link>
						</td>
						<td class="text-right">
							<input type="submit" value="Guardar" class="btn btn-primary">
						</td>
					</tr>
					<tr v-if="sending">
						<td colspan="text-right">Cargando...</td>
					</tr>
				</table>
			</form>

			<div class="errors" v-if="errors">
				<ul>
					<li v-for="message in errors">
						{{ message.join("\n") }}
					</li>
				</ul>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

	import validate from 'validate.js'
	import {toMultipartedForm} from '../../../helpers/form'
	import ImageUpload from '../../form/ImageUpload.vue'

	export default {
		name: 'sell',
		components: {
			ImageUpload
		},
		data() {
			return {
				form: {
					id: 0,
					customer: 0,
					description: '',
					products: [
						{
							id: 0,
							qty: 0,
						}
					],
				},
				products: [],
				customers: [],
				errors: null,
				loading: false,
				message: 'Cargando...',
				sending: false
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		methods: {
			removeProduct(indexFormProduct) {
				if(this.form.products.length > 1) {
					this.form.products.splice(indexFormProduct, 1)
				}
			},
			addProduct() {
				this.form.products.push({
					id: this.products[0].id,
					qty: 0
				})
			},
			save() {
				this.errors = null
				this.sending = true

				const constraints = this.getConstraints()

				this.errors = validate(this.form, constraints)

				if(this.errors) {
					this.sending = false
					return
				}

				if (this.$route.meta.mode == 'edit') {
					const form = toMultipartedForm(this.form, 'create')
					axios.put(`/api/transactions/${this.form.id}`, form)
					.then( response => {
						this.$router.push(`/inventario/ventas/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					const form = toMultipartedForm(this.form, 'create')
					axios.post(`/api/transactions/sales`, form)
					.then( response => {
						this.$router.push('/inventario/ventas')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})

				}
			},
			getConstraints() {
				return {
					customer: {
						presence: {
							message: 'El cliente es obligatorio'
						},
					}
				}
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/transactions/sales/${this.$route.params.id}/edit`)
				.then( response => {
					this.form = response.data.transaction
					this.products = response.data.products
					this.types = response.data.types
					this.providers = response.data.providers
					this.loading = false
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar la transacción'
				})
			} else {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/transactions/sales/create`)
				.then( response => {
					console.log(response.data)
					this.products = response.data.products
					this.customers = response.data.customers

					if(this.products.length > 0)
						this.form.products[0].id = this.products[0].id


					if(this.customers.length > 0)
						this.form.customer = this.customers[0].id

					this.loading = false
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar los datos'
				})

			}
		}
	}
</script>

<style type="text/css">
	.errors {
		background: lightcoral; 
		border-radius: 5px;
		padding: 21px 0 2px 0;
	}
</style>