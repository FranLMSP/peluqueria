	<template>
	<div>
		<div class="col-md-12">
			<div class="card card-default">
				<p class="card-header">Sucursal</p>
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
											<input type="text" class="form-control" v-model="form.name" placeholder="Peluquería">
										</td>
									</tr>
									<tr>
										<th>Dirección</th>
										<td>
											<input type="text" class="form-control" v-model="form.address" placeholder="Calle">
										</td>
									</tr>
									<tr>
										<th>Teléfono</th>
										<td>
											<input type="text" class="form-control" v-model="form.phone" placeholder="+999999">
										</td>
									</tr>
									<tr>
										<th>Teléfono secundario</th>
										<td>
											<input type="text" class="form-control" v-model="form.secondary_phone" placeholder="+999999">
										</td>
									</tr>
									<tr>
										<th>Email</th>
										<td>
											<input type="email" class="form-control" v-model="form.email" placeholder="test@example.com">
										</td>
									</tr>
									<tr>
										<th>Sitio web</th>
										<td>
											<input type="text" class="form-control" v-model="form.website" placeholder="ejemplo.com">
										</td>
									</tr>
									<tr>
										<th>Nombre corto</th>
										<td>
											<input type="text" class="form-control" v-model="form.shortname" placeholder="Pel">
										</td>
									</tr>
									<tr>
										<th>Color</th>
										<td>
											<input type="color" v-model="form.color">
										</td>
									</tr>
									<tr>
										<th>Sillones</th>
										<td>
											<input type="number" v-model="form.boxes">
										</td>
									</tr>
									<tr>
										<th>Comuna y región</th>
										<td>
											<div class="row">
												<div class="col-sm-6">
													<label>Región</label>
													<select class="form-control" v-model="selectedRegion">
														<option :value="region.id" v-for="region in regions">{{ region.name }}</option>
													</select>
												</div>
												<div class="col-sm-6">
													<label>Comuna</label>
													<select class="form-control" v-model="form.commune_id">
														<option :value="commune.id" v-for="commune in communes">{{ commune.name }}</option>
													</select>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<th>Imagen</th>
										<td>
											<image-upload :folder="'/storage/companies/'" v-model="form.image"></image-upload>
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
					address: '',
					phone: '',
					secondary_phone: '',
					email: '',
					website: '',
					shortname: '',
					color: '#FFFFFF',
					boxes: '',
					commune_id: 0,
					image: null
				},
				regions: [],
				selectedRegion: 0,
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
					axios.post(`/api/companies/${this.form.id}`, form)
					.then( response => {
						this.$router.push(`/sucursales/`)
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					const form = toMultipartedForm(this.form, 'create')
					axios.post(`/api/companies`, form)
					.then( response => {
						this.$router.push('/sucursales')
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
						presence: {
							message: 'El nombre es requerido'
						},
					},
					address: {
						presence: {
							message: 'La dirección es requerida'
						}
					},
					phone: {
						presence: {
							message: 'El número de teléfono es requerido'
						}
					},
					email: {
						presence: {
							message: 'El email es requerido'
						}
					},
					boxes: {
						numericality: {
							onlyInteger: {
								message: 'Los sillones deben ser numéricos'
							}
						}
					},
					commune_id: {
						numericality: {
							onlyInteger: {
								message: 'Comuna no válida'
							}
						}
					}
				}
			},

		},
		computed: {
			communes() {
				let communes = []

				for (let i = 0; i<this.regions.length; i++) {
					if (this.regions[i].id == this.selectedRegion) {
						communes = this.regions[i].communes
						this.form.commune_id = communes[0].id
						break
					}
				}

				return communes
			}
		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/companies/${this.$route.params.id}/edit`)
				.then( response => {

					this.form = response.data.company
					this.regions = response.data.regions

					this.selectedRegion = this.form.commune.region.id


				})
				.catch( error => {
					console.log(error)
					this.message = 'Ocurrió un error al cargar la sucursal'
				})
				.then( () => {
					this.loading = false
				})
			} else {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/companies/create`)
				.then( response => {
					this.regions = response.data.regions
					this.selectedRegion = response.data.regions[0].id

				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar los datos'
				})
				.then( () => {
					this.loading = false
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