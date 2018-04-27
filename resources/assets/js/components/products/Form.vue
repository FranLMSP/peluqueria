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
							<form @submit.prevent="save">
								<table class="table">
									<tr>
										<th>Nombre</th>
										<td>
											<input type="text" class="form-control" v-model="form.name" placeholder="Nombres del producto">
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
											<textarea class="form-control" v-model="form.description" placeholder="Identidad"></textarea>
										</td>
									</tr>
									<tr>
										<td>
											<router-link to="/clientes" class="btn btn-default">Regresar</router-link>
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

	export default {
		name: 'create',
		data() {
			return {
				form: {
					id: 0,
					name: '',
					price: '',
					description: ''
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
					return
				}

				if (this.$route.meta.mode == 'edit') {

					axios.put(`/api/products/${this.form.id}`, this.form)
					.then( response => {
						this.$router.push(`/productos/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					axios.post(`/api/products/`, this.form)
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
							message: 'El número de identidad es obligatorio'
						},
						numericality: {
							onlyInteger:false,
							message: 'El número de identidad debe ser numérico'
						}

					}
				}
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/products/${this.$route.params.id}/edit`)
				.then( response => {
					this.form = response.data.customer
					this.loading = false
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar el cliente'
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