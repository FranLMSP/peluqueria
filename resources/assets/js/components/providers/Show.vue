<template>
	<div class="provider-show">
		<div class="row">
			<div class="col-sm-12">
				
				<router-link :to="`/proveedores/${provider.id}/editar`" class="btn btn-primary" style="float: right;">Editar</router-link>
			</div>		
		</div>

		<br>

		<div class="user-info">
			<table class="table">
				<tr>
					<th>ID</th>
					<td>{{ provider.id }}</td>
				</tr>
				<tr>
					<th>Nombres</th>
					<td>{{ provider.name }}</td>
				</tr>
				<tr>
					<th>Descripción</th>
					<td>{{ provider.description }}</td>
				</tr>
			</table>

			<router-link class="btn btn-primary" to="/proveedores">Regresar</router-link>

			<br>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'show',
		data() {
			return {
				provider: {
					id: 0,
					name: '',
					description: ''
				}
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		},
		created() {
			axios.get(`/api/providers/${this.$route.params.id}`)
			.then( response => {
				this.provider = response.data.provider
			})
		}
	}
</script>

<style type="text/css">
	.provider-view {
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