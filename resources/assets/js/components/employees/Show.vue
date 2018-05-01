<template>
	<div class="employee-show">
		<div class="row">
			<div class="col-sm-12">
				
				<router-link :to="`/empleados/${employee.id}/editar`" class="btn btn-primary" style="float: right;">Editar</router-link>
			</div>		
		</div>

		<br>

		<div class="row">
			<div class="col-sm-6">
				<img :src="employee.profile_pic ? '/storage/employees/' + employee.profile_pic : '/img/default/404.png'" class="img-fluid">
			</div>

			<div class="col-sm-6">
				<div class="user-info">
					<table class="table">
						<tr>
							<th>ID</th>
							<td>{{ employee.id }}</td>
						</tr>
						<tr>
							<th>Nombres</th>
							<td>{{ employee.names }}</td>
						</tr>
						<tr>
							<th>Apellidos</th>
							<td>{{ employee.surnames }}</td>
						</tr>
						<tr>
							<th>Número de identidad</th>
							<td>{{ employee.identity_number }}</td>
						</tr>
						<tr>
							<th>Ocupación</th>
							<td><p><strong>{{ employee.occupation.name }}</strong></p><p>{{ employee.occupation.description }}</p></td>
						</tr>
						<tr>
							<th>Email</th>
							<td>{{ employee.email }}</td>
						</tr>
						<tr>
							<th>Teléfono</th>
							<td>{{ employee.phone }}</td>
						</tr>
						<tr>
							<th>Fecha de nacimiento</th>
							<td>{{ employee.birthdate }}</td>
						</tr>
					</table>

					<router-link class="btn btn-primary" to="/empleados">Regresar</router-link>

					<br>
				</div>
			</div>

		</div>


	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				employee: {
					id: 0,
					names: '',
					surnames: '',
					email: '',
					phone: '',
					website: '',
					profile_pic: '',
					occupation: {
						name: '',
						description: ''
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
			axios.get(`/api/employees/${this.$route.params.id}`)
			.then( response => {
				this.employee = response.data.employee
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