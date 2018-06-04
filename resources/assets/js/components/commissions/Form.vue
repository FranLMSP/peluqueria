<template>
	<div v-if="loading">
		<p class="text-align center">{{ message }}</p>
	</div>
	<div v-else>		
		<div class="provider-new">
			<form @submit.prevent="save">
			<div class="row">
				<div class="col-sm-4 offset-8">
					Nueva comisión <button class="btn btn-success" @click.prevent="addCommission">&plus;</button>
				</div>
			</div>
			<hr>
			<div class="row listing" v-for="(commissions, index) in commissionsForm">
				<div class="col-sm-4">
					<label>Servicios</label>
					<select class="form-control" v-model="commissions.services" data-placeholder="Seleccione los servicios" multiple>
						<option :selected="isServiceSelected(service, commissions.services)" :value="service.id" v-for="service in services">
							{{ service.definition.name }}
						</option>
					</select>
				</div>
				<div class="col-sm-4">
					<label>Empleados</label>
					<select class="form-control" v-model="commissions.employees" data-placeholder="Seleccione los empleados" multiple>
						<option :selected="isEmployeeSelected(employee, commissions.employees)" :value="employee.id" v-for="employee in employees">
							{{ employee.names }} {{ employee.surnames }}
						</option>
					</select>
				</div>
				<div class="col-sm-2">
					<label>Porcentaje</label>
					<input class="form-control" type="number" name="percentage" v-model="commissions.percentage">
				</div>
				<div class="col-sm-2">
					<button class="btn" :class="commissionsForm.length <= 1 ? '' : 'btn-danger'" @click.prevent="removeCommission(index)">&times;</button>
				</div>
			</div>

			<br>

			<div class="row">
				<div class="col-sm-12">
					<button style="float: right" class="btn btn-primary">Guardar</button>
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
			}
		},
		methods: {
			save() {
				this.errors = null
				this.sending = true

				if (this.$route.meta.mode == 'edit') {

					axios.put(`/api/commissions`, this.formParsed())
					.then( response => {
						this.$router.push('/comisiones')
					})
					.catch( error => {
						this.errors = error.response.data.errors
						this.sending = false
					})
					
				} else {
					axios.post(`/api/commissions`, this.formParsed())
					.then( response => {
						this.$router.push('/comisiones')
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
			},
			isServiceSelected(service, options) {
				for(let i = 0; i<options.length; i++) {
					if(options[i] == service)
						return true
				}
				return false
			},
			isEmployeeSelected(employee, options) {
				for(let i = 0; i<options.length; i++) {
					if(options[i] == employee)
						return true
				}
				return false
			},
			addCommission() {
				this.commissionsForm.push({
					employees: [],
					services: [],
					percentage: 0
				})
			},
			removeCommission(index) {
				if(this.commissionsForm.length > 1)
					this.commissionsForm.splice(index, 1)
			},
			findPercentage(form, per) {
				for (let i = 0; i<form.length; i++) {
					if (form[i].percentage == per) {
						return i
					}
				}

				return false
			},
			findEmployeeService(form, employee, service) {
				for(let i = 0; i<form.length; i++) {
					if(form[i].service.id == service && form[i].employee.id == employee) {
						return true
					}
				}

				return false
			},
			prepareForm(commissions) {
				let form = []

				for (let i = 0; i<commissions.length; i++) {
					let findedPercentage = this.findPercentage(form, commissions[i].percentage)
					if ( findedPercentage === false) {
						form.push({
							employees: [
								commissions[i].employee.id
							],
							services: [
								commissions[i].service.id
							],
							percentage: commissions[i].percentage,
							id: commissions[i].id
						})
					} else {
						form[findedPercentage].employees.push(commissions[i].employee.id)
						form[findedPercentage].employees.push(commissions[i].service.id)
					}
				}

				return form

			},
			formParsed() {
				let form = []
				for(let i=0; i<this.commissionsForm.length; i++) {
					
					for(let j=0; j<this.commissionsForm[i].employees.length; j++) {
						
						for(let k=0; k<this.commissionsForm[i].services.length; k++) {
							form.push({
								id: this.commissionsForm[i].id,
								employee: this.commissionsForm[i].employees[j],
								service: this.commissionsForm[i].services[k],
								percentage: this.commissionsForm[i].percentage
							})
						}
					}
				}

				return {
					commissions: form
				}
			}

		},
		created() {
			if(this.$route.meta.mode == 'edit') {
				this.loading = true
				this.message = 'Cargando...'
				axios.get(`/api/commissions/${this.$route.params.ids}/edit`)
				.then( response => {
					this.employees = response.data.employees
					this.services = response.data.services

					this.commissionsForm = this.prepareForm(response.data.commissions)

					this.loading = false
				
				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar el proveedor'
				})
			} else {
				this.loading = true
				this.message = 'Cargando...'
				axios.get('/api/commissions/create')
				.then( response => {
					this.employees = response.data.employees
					this.services = response.data.services

					this.loading = false

				})
				.catch( error => {
					this.message = 'Ocurrió un error al cargar la información necesaria'
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