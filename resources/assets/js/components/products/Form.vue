	<template>
	<div>
		<div class="col-md-12">
			<div class="card card-default">
				<p class="card-header">Producto</p>
				<div class="card-body">
					
					<div v-if="loading">
						<p class="text-align center">{{ message }}</p>
					</div>
					<div v-else>		
						<div class="customer-new">
							<form @submit.prevent="save" enctype="multipart/form-data">
								<table class="table">
									<tr>
										<th>Nombre</th>
										<td>
											<input type="text" class="form-control" v-model="form.name" :placeholder="`Nombre del ${form.type=='P' ? 'producto' : 'servicio'}`">
										</td>
									</tr>

									<tr>
										<th>Tipo</th>
										<td>
											<div class="row">
												<div class="col-sm-6">
													<label class="radio-inline" style="cursor:pointer">
													<input type="radio" value="P" v-model="form.type">Producto
													</label>
												</div>

												<div class="col-sm-6">												
													<label class="radio-inline" style="cursor:pointer">
													<input type="radio" value="S" v-model="form.type">Servicio
													</label>
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<th>Precio</th>
										<td>
											<input type="text" class="form-control" v-model="form.price" placeholder="10000.00">
										</td>
									</tr>

									<tr>
										<th>Descripción</th>
										<td>
											<textarea class="form-control" v-model="form.description" :placeholder="`Descripción del ${form.type=='P' ? 'producto' : 'servicio'}`"></textarea>
										</td>
									</tr>
									<tr>
										<th>Imagen</th>
										<td>
											<image-upload :folder="'/storage/products/'" v-model="form.image"></image-upload>
										</td>
									</tr>
									<tr>
										<td>
											<router-link to="/productos" class="btn btn-default">Regresar</router-link>
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
				</div>
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
					name: '',
					price: '',
					description: '',
					type: 'P',
					image: null
				},
				errors: null,
				loading: false,
				message: 'Cargando...',
				sending: false
			}
		},
		methods: {
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
					form.append('_method', 'PATCH')
					axios.post(`/api/products/${this.form.id}`, form)
					.then( response => {
						this.$router.push(`/productos/`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					const form = toMultipartedForm(this.form, 'create')
					axios.post(`/api/products`, form)
					.then( response => {
						this.$router.push('/productos')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})

				}
			},
			getConstraints() {
				return {
					name: {
						presence: true,
						length: {
							minimum: 3,
							message: 'El nombre debe tener al menos 3 caracteres'
						}
					},
					price: {
						presence: {
							message: 'El precio es obligatorio'
						},
						numericality: {
							onlyInteger:false,
							message: 'El precio debe ser numérico'
						}

					}
				}
			},

		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/products/${this.$route.params.id}/edit`)
				.then( response => {
					this.form = {
						id: response.data.product.id,
						name: response.data.product.definition.name,
						description: response.data.product.definition.description,
						price: response.data.product.price,
						type: response.data.product.definition.type,
						image: response.data.product.definition.image,
					}

					this.loading = false
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar el producto'
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