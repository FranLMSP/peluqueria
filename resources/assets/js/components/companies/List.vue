<template>
	<div>
		<div class="row">
			<div class="col-sm-12">
				<router-link to="/">Regresar</router-link>
				<router-link to="/sucursales/crear" class="btn btn-primary float-right">Crear</router-link>
			</div>
		</div>

		<div class="row" v-if="(companiesList && companiesList.length > 0) || mainCompany">

			<div class="col-sm-4">
				<div class="card text-white bg-secondary mb-4" style="width: 100%;">
					<img class="card-img-top" :src="mainCompany.image ? '/storage/companies/'+mainCompany.image : '/img/default/404.png'" alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title">{{ mainCompany.name }}</h5>
						<router-link style="background-color: white" class="btn btn-default" :to="`/sucursales/${mainCompany.id}`">Detalles</router-link>
						<router-link :to="`/sucursales/${mainCompany.id}/editar`" class="btn btn-primary">Editar</router-link>
					</div>
				</div>
			</div>

			<div class="col-sm-4" v-for="company in companiesList">
				<div class="card mb-4" style="width: 100%;">
					<img class="card-img-top" :src="company.image ? '/storage/companies/'+company.image : '/img/default/404.png'" alt="Card image cap">
					<div class="card-body">
						<h5 class="card-title">{{ company.name }}</h5>
						<router-link :to="`/sucursales/${company.id}`">Detalles</router-link>
						<router-link :to="`/sucursales/${company.id}/editar`" class="btn btn-primary">Editar</router-link>
					</div>
				</div>
			</div>
		</div>
		<div class="row" v-else>
			<p class="text-align center">{{ listMessage }}</p>
		</div>
	</div>
</template>

<script type="text/javascript">
	export default {
		name: 'list',
		data() {
			return {
				companies: [],
				loading: false,
				error: false
			}
		},
		methods: {
			get() {
				this.loading = true
				this.error = false
				this.companies = []
				axios('/api/companies')
				.then( response => {
					this.companies = response.data.companies
					console.log(this.companies)
					this.loading = false
				})
				.catch( error => {
					this.loading = false
					this.error = true
				})
			}
		},
		computed: {
			listMessage() {
				if(this.loading) {
					return 'Cargando...'
				}

				if(this.error) {
					return 'Ocurrió un error al listar los sucursales'
				}

				if(!this.companiesList || this.companiesList.length <= 0){
					return 'Sin sucursales disponibles'
				}
			},
			companiesList() {
				return this.companies.filter( company => {
					return company.main == false
				})
			},
			mainCompany() {
				for(let i = 0; i<this.companies.length; i++) {
					if(this.companies[i].main)
						return this.companies[i]
				}
				return null
			}
		},
		created() {
			this.get()
		}
	}
</script>