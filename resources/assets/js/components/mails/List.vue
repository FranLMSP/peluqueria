<template>
	<div>
		<div class="btn-wrapper">
			
			<router-link class="btn btn-primary btn-sm" to="/correos/crear">Nuevo</router-link>		
		</div>
		
		<table class="table" style="width: 100%">
			<thead>
				<tr>
					<th>Para</th>
					<th>Asunto</th>
					<th>Status</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="!mails || mails.length <= 0">
					<tr>
						<td colspan="4" class="text-center">{{ tableMessage }}</td>
					</tr>
				</template>

				<template v-else>
					<tr v-for="mail in mails" :key="mail.id">
						<td>{{ mail.email }}</td>
						<td>{{ mail.subject }}</td>
						<td>{{ mail.status.name }}</td>
						<td>
							<router-link :to="`/correos/${mail.id}`">Detalles</router-link>
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
				mails: [],
				loading: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.mails = []
				axios('/api/mail')
				.then( response => {
					this.mails = response.data.mails
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
				if (!this.mails || this.mails.length <= 0) {
					return 'Sin correos'
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