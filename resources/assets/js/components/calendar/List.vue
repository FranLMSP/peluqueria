<template>
	<div>
		<div class="row">
			<div class="col-sm-6">
				<h3>{{ date.date | formatDate }}</h3>
			</div>
			<div class="col-sm-6">
				<button @click="emitNewForm" class="btn btn-primary pull-right">Nuevo</button>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<template v-if="date.data && date.data.length > 0">
					<div @click="emitEditForm(cite)" v-for="cite in date.data">
						
					<div class="card" >
						<div class="card-body">
							<p><strong>Hora: </strong>{{ new Date(cite.date).getTime() | formatHour }}</p>
							<p><strong>Cliente: </strong>{{ cite.customer.names }} {{ cite.customer.surnames }}</p>
							<p><strong>Datos de contacto: </strong>{{ cite.customer.email }} - {{ cite.customer.phone }}</p>
							<p><strong>Servicio: </strong>{{ cite.service.definition.name }}</p>
							<p><strong>Profesional: </strong>{{ cite.employee.names }} {{ cite.employee.surnames }} ({{ cite.employee.occupation.name }})</p>
							<p><strong>Estado: </strong> <span :style="`color: ${cite.status.active ? 'green' : 'red'}`">{{ cite.status.name }}</span></p>
							<p><strong>Notas adicionales:</strong></p>
							<p>{{ cite.notes }}</p>
						</div>
					</div>
					<br>
					</div>

				</template>
				<p v-else>Sin citas para este día</p>
			</div>
		</div>

	</div>
</template>

<script type="text/javascript">
	export default {
		props: [
			'date',
		],
		data() {
			return {
				
			}
		},
		methods: {
			emitEditForm(data) {
				data.context = 'edit'
				this.$root.$emit('CalendarForm', data)
			},
			emitNewForm() {
				const data = {
					context: 'create',
					date: this.date.date
				}
				this.$root.$emit('CalendarForm', data)
			}
		},
		filters: {
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
		created() {

		}
	}
</script>