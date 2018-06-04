<template>
	<div class="mail-show">
		<div class="row">
			<div class="col-sm-12">
				
				<router-link :to="`/empleados/${mail.id}/editar`" class="btn btn-primary" style="float: right;">Editar</router-link>
			</div>		
		</div>

		<br>

		<div class="row">

			<div class="col-sm-12">
				<div class="user-info">
					<table class="table">
						<tr>
							<th>ID</th>
							<td>{{ mail.id }}</td>
						</tr>
						<tr>
							<th>Cliente</th>
							<td>
								<template v-if="!mail.customer">
									-
								</template>
								<template v-else>
									{{ mail.customer.names }} {{ mail.customer.surnames }}
								</template>
							</td>
						</tr>
						<tr>
							<th>Para</th>
							<td>{{ mail.email }}</td>
						</tr>
						<tr>
							<th>Asunto</th>
							<td>{{ mail.subject }}</td>
						</tr>
						<tr>
							<th>Mensaje</th>
							<td>{{ mail.message }}</td>
						</tr>
						<tr>
							<th>Estatus</th>
							<td>{{ mail.status.name }}</td>
						</tr>
					</table>


				</div>
			</div>

		</div>

		<router-link class="btn btn-primary" to="/correos">Regresar</router-link>

		<br>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				mail: {
					id: 0,
					email: '',
					subject: '',
					message: '',
					status_id: '',
					customer_id: '',
					customer: null,
					status: {
						name: ''
					}
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		created() {
			axios.get(`/api/mail/${this.$route.params.id}`)
			.then( response => {
				this.mail = response.data.mail
			})
		}
	}
</script>

<style type="text/css">
	.employee-view {
		display: flex;
		align-items: center;
	}

	.user-img {
		flex: 1;
	}

	.user-img img {
		max-width: 160px
	}

	.user-info {
		flex: 3;
		overflow-x: scroll;
	}
</style>