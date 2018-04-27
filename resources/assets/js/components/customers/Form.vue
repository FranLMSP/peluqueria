<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="customer-new">
			<form @submit.prevent="save">
				<table class="table">
					<tr>
						<th>Nombres</th>
						<td>
							<input type="text" class="form-control" v-model="form.names" placeholder="Nombres del cliente">
						</td>
					</tr>

					<tr>
						<th>Apellidos</th>
						<td>
							<input type="text" class="form-control" v-model="form.surnames" placeholder="Apellidos del cliente">
						</td>
					</tr>

					<tr>
						<th>Número de identidad</th>
						<td>
							<input type="text" class="form-control" v-model="form.identity_number" placeholder="Identidad">
						</td>
					</tr>

					<tr>
						<th>Email</th>
						<td>
							<input type="email" class="form-control" v-model="form.email" placeholder="example@example.com">
						</td>
					</tr>

					<tr>
						<th>Teléfono</th>
						<td>
							<input type="text" class="form-control" v-model="form.phone" placeholder="Número de teléfono">
						</td>
					</tr>

					<tr>
						<th>Cumpleaños</th>
						<td>
							<input type="date" class="form-control" v-model="form.birthdate" placeholder="Website">
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
</template>

<script type="text/javascript">

	import validate from 'validate.js'

	export default {
		name: 'create',
		data() {
			return {
				form: {
					id: 0,
					names: '',
					surnames: '',
					identity_number: '',
					phone: '',
					email: '',
					birthdate: ''
				},
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
			save() {
				this.errors = null
				this.sending = true

				const constraints = this.getConstraints()

				this.errors = validate(this.form, constraints)

				if(this.errors) {
					return
				}

				if (this.$route.meta.mode == 'edit') {

					axios.put(`/api/customers/${this.form.id}`, this.form)
					.then( response => {
						this.$router.push(`/clientes/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					axios.post(`/api/customers/`, this.form)
					.then( response => {
						this.$router.push('/clientes')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})

				}
			},
			getConstraints() {
				return {
					names: {
						presence: true,
						length: {
							minimum: 3,
							message: 'El nombre debe tener al menos 3 caracteres'
						}
					},
					identity_number: {
						onlyInteger: true,
						presence: {
							message: 'El número de identidad es obligatorio'
						},
						numericality: {
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
				axios.get(`/api/customers/${this.$route.params.id}/edit`)
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