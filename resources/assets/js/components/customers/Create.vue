<template>
	<div class="costumer-new">
		<form @submit.prevent="create">
			<table class="table">
				<tr>
					<th>Nombre</th>
					<td>
						<input type="text" class="form-control" v-model="customer.name" placeholder="Nombre del cliente">
					</td>
				</tr>

				<tr>
					<th>Email</th>
					<td>
						<input type="email" class="form-control" v-model="customer.email" placeholder="Correo electrónico">
					</td>
				</tr>

				<tr>
					<th>Teléfono</th>
					<td>
						<input type="text" class="form-control" v-model="customer.phone" placeholder="Número de teléfono">
					</td>
				</tr>

				<tr>
					<th>Sitio web</th>
					<td>
						<input type="text" class="form-control" v-model="customer.website" placeholder="Website">
					</td>
				</tr>
				<tr>
					<td>
						<router-link to="/clientes" class="btn btn-default">Regresar</router-link>
					</td>
					<td class="text-right">
						<input type="submit" value="Crear" class="btn btn-primary">
					</td>
				</tr>
			</table>
		</form>

		<div class="errors" v-if="errors">
			<ul>
				<li v-for="(message, field) in errors" :key="field">
					<strong>{{ field }}</strong> {{ message.join("\n") }}
				</li>
			</ul>
		</div>
	</div>
</template>

<script type="text/javascript">

	import validate from 'validate.js'

	export default {
		name: 'create',
		data() {
			return {
				customer: {
					id: 0,
					name: '',
					email: '',
					website: ''
				},
				errors: null
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		methods: {
			create() {
				this.errors = null

				const constraints = this.getConstraints()

				this.errors = validate(this.customer, constraints)

				if(this.errors) {
					return
				}

				axios.post('/api/customers/', this.customer, {
					headers: {
						"Authorization": `Bearer ${this.currentUser.token}`
					}
				})
				.then( response => {
					this.$router.push('/clientes')
				})
				.catch( error => {

				})
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
					email: {
						presence: true,
						email: true
					},
					phone: {
						presence: true,
						numericality: true,
						length: {
							minimum: 10,
							message: 'El número de telefono debe tener al menos 10 caracteres'
						}
					},
					website: {
						presence: true,
						url: true
					}
				}
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