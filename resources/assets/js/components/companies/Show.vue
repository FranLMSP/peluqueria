<template>
	<div class="company-show">
		<div class="row">
			<div class="col-sm-12">
				
				<router-link :to="`/sucursales/${company.id}/editar`" class="btn btn-primary" style="float: right;">Editar</router-link>
			</div>		
		</div>

		<br>

		<div class="user-info">
			<div class="row">
				<div class="col-sm-6">
					<img class="img-thumbnail" :src="company.image ? '/storage/companies/'+company.image : '/img/default/404.png'" alt="Card image cap">
				</div>
				<div class="col-sm-6">
					<table class="table">
						<tr>
							<th>ID</th>
							<td>{{ company.id }}</td>
						</tr>
						<tr>
							<th>Nombre</th>
							<td>{{ company.name }}</td>
						</tr>
						<tr>
							<th>Dirección</th>
							<td>{{ company.address }}</td>
						</tr>
						<tr>
							<th>Teléfono</th>
							<td>{{ company.phone }}</td>
						</tr>
						<tr>
							<th>Teléfono secundario</th>
							<td>{{ company.secondary_phone }}</td>
						</tr>
						<tr>
							<th>Email</th>
							<td>{{ company.email }}</td>
						</tr>
						<tr>
							<th>Sitio web</th>
							<td>{{ company.website }}</td>
						</tr>
						<tr>
							<th>Nombre corto</th>
							<td>{{ company.shortname }}</td>
						</tr>
						<tr>
							<th>Color</th>
							<td><div :style="`background-color: ${company.color}`" style="width: 50px; height: 50px; "></div></td>
						</tr>
						<tr>
							<th>Región</th>
							<td>{{ company.commune.region.name }}</td>
						</tr>
						<tr>
							<th>Comuna</th>
							<td>{{ company.commune.name }}</td>
						</tr>
					</table>
				</div>
			</div>

			<router-link class="btn btn-primary" to="/sucursales">Regresar</router-link>

			<br>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				company: {
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
					commune: {
						name: '',
						region: {
							name: ''
						}
					},
					image: null
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		created() {
			axios.get(`/api/companies/${this.$route.params.id}`)
			.then( response => {
				this.company = response.data.company
			})
		}
	}
</script>

<style type="text/css">
	.company-view {
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