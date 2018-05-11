<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="customer-new">
			<form @submit.prevent="save">
				<table class="table">
					<tr>
						<th>Tipo</th>
						<td>
							<div class="form-group">
								<select class="form-control" v-model="form.type" :data-selected="form.type">
									<option :selected="type.id == form.type ? 'selected':''" v-for="type in types" :value="type.id">{{ type.name }}</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Proveedor</th>
						<td>
							<div class="form-group">
								<select class="form-control" v-model="form.provider" :data-selected="form.provider">
									<option :selected="provider.id == form.provider ? 'selected' : ''" v-for="provider in providers" :value="provider.id">{{ provider.name }}</option>
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
							<router-link to="/inventario" class="btn btn-default">Regresar</router-link>
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
	import {toMultipartedForm} from '../../helpers/form'
	import ImageUpload from '../form/ImageUpload.vue'

	export default {
		name: 'create',
		components: {
			ImageUpload
		},
		data() {
			return {
				form: {
					id: 0,
					customer: '',
					provider: 0,
					type: 0,
					description: '',
					products: [
						{
							id: 0,
							qty: 0,
						}
					],
				},
				products: [],
				types: [],
				providers: [],
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
						this.$router.push(`/inventario/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					const form = toMultipartedForm(this.form, 'create')
					axios.post(`/api/transactions/`, form)
					.then( response => {
						this.$router.push('/inventario')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})

				}
			},
			getConstraints() {
				return {
					type: {
						presence: {
							message: 'El tipo de transacción es obligatorio'
						},
					},
					provider: {
						presence: {
							message: 'El proveedor es obligatorio'
						},
					}
				}
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/transactions/${this.$route.params.id}/edit`)
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
				axios.get(`/api/transactions/create`)
				.then( response => {
					this.products = response.data.products
					this.types = response.data.types
					this.providers = response.data.providers

					if(this.products.length > 0)
						this.form.products[0].id = this.products[0].id

					if(this.types.length > 0)
						this.form.type = this.types[0].id

					if(this.providers.length > 0)
						this.form.provider = this.providers[0].id

					this.loading = false
				})
				.catch( error => {
					console.log(error)
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