<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/proveedores/crear">Crear</router-link>		
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!providers || providers.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="provider in providers" :key="provider.id">
						<td>{{ provider.name }}</td>
						<td>{{ provider.description }}</td>
						<td>
							<router-link :to="`/proveedores/${provider.id}`">Detalles</router-link>
						</td>
					</tr>
				</template>
			</tbody>
		</table>
	</div>
</template>

<script type="text/javascript">

	export default {
		name: 'list',
		data() {
			return {
				providers: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.providers = []
				axios('/api/providers')
				.then( response => {
					this.providers = response.data.providers
					this.loading = false
				})
				.catch( error => {
					this.loading = false
				})

			}
		},
		computed: {
			tableMessage() {
				if (this.loading) {
					return 'Cargando...'
				}
				if (!this.providers || this.providers.length <= 0) {
					return 'Sin proveedores'
				}
				return ''
			}
		},
		created() {
			this.get()
		}
	}
</script>

<style type="text/css">
	.btn-wrapper {
		text-align: right;
		margin-bottom: 20px;
	}
</style>