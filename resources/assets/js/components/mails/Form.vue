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
							<select v-model="form.customer_id" class="form-control">
								<option :value="0">Ninguno</option>
								<option :value="customer.id" v-for="customer in customers">{{ customer.names }} {{ customer.surnames }} ({{ customer.email }})</option>
							</select>
						</td>
					</tr>

					<tr>
						<th>Email</th>
						<td>
							<input type="text" class="form-control" v-model="form.email" :disabled="form.customer_id == 0 ? false : true">
						</td>
					</tr>

					<tr>
						<th>Asunto</th>
						<td>
							<input type="text" class="form-control" v-model="form.subject">
						</td>
					</tr>

					<tr>
						<th>Mensaje</th>
						<td>
							<textarea class="form-control" v-model="form.message"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<router-link to="/empleados" class="btn btn-default">Regresar</router-link>
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
					customer_id: 0,
					email: '',
					subject: '',
					message: '',
				},
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
			save() {
				this.errors = null
				this.sending = true

				if(this.form.customer_id === 0)
					this.form.customer_id = null

				if (this.$route.meta.mode == 'edit') {
					const form = toMultipartedForm(this.form, 'create')
					form.append('_method', 'PATCH')
					axios.post(`/api/employees/${this.form.id}`, form)
					.then( response => {
						this.$router.push(`/empleados/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					axios.post(`/api/mail`, this.form)
					.then( response => {
						this.$router.push('/correos')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})

				}
			},
			getConstraints() {
				return {
				}
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/employees/${this.$route.params.id}/edit`)
				.then( response => {
					response.data.employee.occupation = response.data.employee.occupation_id
					this.form = response.data.employee
					this.occupations = response.data.occupations
					this.loading = false

				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar el empleado'
				})
			} else {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/mail/create`)
				.then( response => {
					this.customers = response.data.customers
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