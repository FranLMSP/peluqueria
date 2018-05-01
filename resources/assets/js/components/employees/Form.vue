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
							<input type="text" class="form-control" v-model="form.names" placeholder="Nombres del empleado">
						</td>
					</tr>

					<tr>
						<th>Apellidos</th>
						<td>
							<input type="text" class="form-control" v-model="form.surnames" placeholder="Apellidos del empleado">
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
						<th>Fecha de nacimiento</th>
						<td>
							<input type="date" class="form-control" v-model="form.birthdate" placeholder="Website">
						</td>
					</tr>

					<tr>
						<th>Cargo</th>
						<td>
							<div class="form-group">

								<select class="form-control" v-model="form.occupation">
									<option :selected="occupation.id == form.occupation" v-for="occupation in occupations" :value="occupation.id">{{ occupation.name }}</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<th>Foto</th>
						<td>
							<image-upload v-model="form.profile_pic"></image-upload>
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
					names: '',
					surnames: '',
					identity_number: '',
					phone: '',
					email: '',
					birthdate: '',
					profile_pic: '',
					occupation: 0
				},
				occupations: [],
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
					this.sending = false
					return
				}

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
					const form = toMultipartedForm(this.form, 'create')
					axios.post(`/api/employees/`, form)
					.then( response => {
						this.$router.push('/empleados')
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
						
						presence: {
							message: 'El número de identidad es obligatorio'
						},
						numericality: {
							onlyInteger: true,
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
				axios.get(`/api/employees/${this.$route.params.id}/edit`)
				.then( response => {
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
				axios.get(`/api/employees/create`)
				.then( response => {
					this.occupations = response.data.occupations
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