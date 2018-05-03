<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="provider-new">
			<form @submit.prevent="save">
				<table class="table">
					<tr>
						<th>Nombre</th>
						<td>
							<input type="text" class="form-control" v-model="form.name" placeholder="Nombres del proveedor">
						</td>
					</tr>

					<tr>
						<th>Descripción</th>
						<td>
							<textarea class="form-control" v-model="form.description" placeholder="Apellidos del proveedor"></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<router-link to="/proveedores" class="btn btn-default">Regresar</router-link>
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
					name: '',
					description: ''
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