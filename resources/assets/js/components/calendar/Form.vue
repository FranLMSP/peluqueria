<template>
	<div>
		<template v-if="data">
			<form @submit.prevent="save">			
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" class="btn btn-primary pull-right">Enviar</button>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-sm-12">
								<input id="nuevocliente" type="radio" v-model="newCustomer" :value="true"> <label for="nuevocliente">Nuevo cliente</label> <input id="clienteexistente" type="radio" v-model="newCustomer" :value="false"> <label for="clienteexistente">Cliente existente</label>
							</div>
						</div>

						<div class="row" v-if="!newCustomer">
							<div class="col-sm-12">
								<label>Cliente</label>
								<select class="form-control" v-model="form.customer_id" >
									<option 
										v-for="customer in createdata.customers"
										:value="customer.id"
									>
										{{ customer.names }} {{ customer.surnames }}
									</option>
								</select>
							</div>
						</div>
						<template v-else>
							<div class="card">
								<div class="card-body">
									
									<div class="row">
										<div class="col-sm-12">
											<label>Nombre del cliente</label>
											<input type="text" class="form-control" v-model="form.customer.names" placeholder="Pedro">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<label>Apellido del cliente</label>
											<input type="text" class="form-control" v-model="form.customer.surnames" placeholder="Perez">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<label>Número de identidad del cliente</label>
											<input type="text" class="form-control" v-model="form.customer.identity_number">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<label>Correo del cliente</label>
											<input type="text" class="form-control" v-model="form.customer.email">
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12">
											<label>Teléfono del cliente</label>
											<input type="text" class="form-control" v-model="form.customer.phone">
										</div>
									</div>
								</div>
							</div>
						</template>

						<div class="row">
							<div class="col-sm-12">
								<label>Profesional</label>
								<select class="form-control" v-model="form.employee_id" >
									<option 
										v-for="employee in createdata.employees"
										:value="employee.id"
									>
										{{ employee.names }} {{ employee.surnames }} ({{ employee.occupation.name }})
									</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label>Status</label>
								<select class="form-control" v-model="form.status_id" :style="`color: ${selectedStatus.active ? 'green' : 'red'}`" >
									<option 
										v-for="status in createdata.statuses"
										:value="status.id"
										:style="`color: ${status.active ? 'green' : 'red'}`"
									>
										{{ status.name }}
									</option>
								</select>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label>Fecha</label>
								<input class="form-control" type="date" v-model="form.date">	
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label>Hora</label>
								<input class="form-control" type="text" v-model="form.time">
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<label>Notas adicionales</label>
								<textarea class="form-control" v-model="form.notes"></textarea>
							</div>
						</div>
					</div>
				</div>
			</form>
			<div v-show="loading">
				<p>Cargando...</p>
			</div>
			<div class="errors" v-show="errors">
				<ul>
					<li v-for="message in errors">
						{{ message.join("\n") }}
					</li>
				</ul>
			</div>
		</template>
	</div>
</template>

<script type="text/javascript">
	export default {
		props: ['createdata', 'data'],
		name: 'form-calendar',
		data() {
			return {
				form: {
					customer: {
						names: '',
						surnames: '',
						identity_number: '',
						phone: '',
						email: '',
					},
					notes: '',
					date: '',
					time: '',
					customer_id: null,
					status_id: null,
					service_id: null,
					employee_id: null,
				},
				newCustomer: false,
				loading: false,
				errors: null
			}
		},
		methods: {
			save() {
				this.loading = true
				let form = this.form
				if(this.data.context == 'create') {
					if(this.newCustomer) {
						form.customer_id = null
					} else {
						form.customer.names = 'a'
						form.customer.identity_number = '0'
					}

					this.form.date = this.form.date + ' ' + this.form.time

					axios.post('/api/calendar/', this.form)
					.then( response => {
						alert('Creado correctamente')
						this.errors = null
						this.$root.$emit('UpdateCalendar')
					})
					.catch( error => {
						this.errors = error.response.data.errors
					})
					.then( () => {
						this.loading = false
					})



				} else if(this.data.context == 'edit') {

				}
			},
			formatDate(date) {
				let d = new Date(date),
			        month = '' + (d.getMonth() + 1),
			        day = '' + d.getDate(),
			        year = d.getFullYear()

			    if (month.length < 2) month = '0' + month
			    if (day.length < 2) day = '0' + day

			    return [year, month, day].join('-')
			},
			formatHour(timestamp) {
			  let date = new Date(timestamp * 1000)
			  let hours = date.getHours()
			  let minutes = date.getMinutes()
			  let seconds = date.getSeconds()
			  return ("0"+hours).slice(-2)+":"+("0"+minutes).slice(-2)+":"+("0"+seconds).slice(-2)
			}
		},
		computed: {
			selectedStatus() {
				if(this.createdata && this.createdata.statuses) {
					for(let i = 0; i<this.createdata.statuses.length; i++) {
						if(this.createdata.statuses[i].id == this.form.status_id) {
							return this.createdata.statuses[i]
						}
					}
				}
				return {
					active: false
				}
			}
		},
		created() {

			this.$root.$on('CalendarForm', data => {

				if(data.context == 'create') {
					this.form = {
						customer: {
							names: '',
							surnames: '',
							identity_number: '',
							phone: '',
							email: '',
						},
						notes: '',
						date: this.formatDate(data.date),
						time: '00:00:00',
						customer_id: null,
						status_id: null,
						service_id: null,
						employee_id: null,
					}
					if(this.createdata.customers[0]) {
						this.form.customer_id = this.createdata.customers[0].id
					}

					if(this.createdata.statuses[0]) {
						this.form.status_id = this.createdata.statuses[0].id
					}

					if(this.createdata.employees[0]) {
						this.form.employee_id = this.createdata.employees[0].id
					}

					if(this.createdata.services[0]) {
						this.form.service_id = this.createdata.services[0].id
					}
				} else if(data.context == 'edit') {
					this.form = {
						customer: {
							names: '',
							surnames: '',
							identity_number: '',
							phone: '',
							email: '',
						},
						notes: data.notes,
						date: this.formatDate(data.date),
						time: this.formatHour(new Date(data.date).getTime()),
						customer_id: data.customer_id,
						status_id: data.status_id,
						service_id: data.service_id,
						employee_id: data.employee_id,
					}
				}


			})

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