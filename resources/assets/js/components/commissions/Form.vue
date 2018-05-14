<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="provider-new">
			<form @submit.prevent="save">
			
			<div class="row" v-for="commissions in commissionsForm">
				<div class="col-sm-4">
					<label>Servicios</label>
					<select v-model="commissions.services" multiple>
						<option :disabled="isServiceSelected(service)" :value="service.id" v-for="service in services">
							{{ service.name }}
						</option>
					</select>
				</div>
				<div class="col-sm-4">
					<label>Empleados</label>
					<select v-model="commissions.employees" multiple>
						<option :disabled="isEmployeeSelected(employee)" :value="employee.id" v-for="employee in employees">
							{{ employee.names }} {{ employee.surnames }}
						</option>
					</select>
				</div>
				<div class="col-sm-4">
					<label>Porcentaje</label>
					<input class="form-control" type="text" name="percentage" v-model="commissions.percentage">
				</div>
			</div>

			</form>

			<div class="row">
				<div class="col-sm-12">				
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
</template>

<script type="text/javascript">

	import validate from 'validate.js'

	export default {
		name: 'create',
		data() {
			return {
				commissionsForm: [
					{
						employees: [],
						services: [],
						percentage: 0
					}
				],
				services: [],
				employees: [],
				errors: null,
				loading: false,
				message: 'Cargando...',
				sending: false
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			},
			isServiceSelected() {
				return false
			},
			isEmployeeSelected() {
				return false
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

					axios.put(`/api/providers/${this.form.id}`, this.form)
					.then( response => {
						this.$router.push(`/proveedores/${this.form.id}`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					axios.post(`/api/providers/`, this.form)
					.then( response => {
						this.$router.push('/proveedores')
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
					}
				}
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/providers/${this.$route.params.id}/edit`)
				.then( response => {
					this.form = response.data.provider
					this.loading = false
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar el proveedor'
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