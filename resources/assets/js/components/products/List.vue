<template>
	<div>
		<div class="row">
			<div class="col-sm-12">
				<router-link to="/">Regresar</router-link>
				<router-link to="/productos/crear" class="btn btn-primary float-right">Crear</router-link>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4 offset-8">
				<div class="form-group">
					<label for="type">Filtrar</label>
					<select class="form-control" v-model="type" id="type">
						<option value="A">Todos</option>
						<option value="P">Productos</option>
						<option value="S">Servicios</option>
					</select>
				</div>
			</div>
		</div>

		<hr>

		<div class="row" v-if="productsList && productsList.length > 0">
			<div class="col-sm-4" v-for="product in productsList">
				<div class="card mb-4" style="width: 100%;">
					<img class="card-img-top" :src="product.definition.image ? '/storage/products/'+product.definition.image : '/img/default/404.png'" alt="Card image cap">
					<div class="card-body">
						<p class="text-right text-muted">{{ product.price }}</p>
						<p class="text-left text-muted">{{ product.definition.type == 'P' ? 'Producto' : 'Servicio' }}</p>
						<h5 class="card-title">{{ product.definition.name }}</h5>
						<p class="card-text">{{ product.definition.description }}</p>
						<router-link :to="`/productos/${product.id}/editar`" class="btn btn-primary">Editar</router-link>
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
				products: [],
				loading: false,
				error: false,
				type: 'A'
			}
		},
		methods: {
			get() {
				this.loading = true
				this.error = false
				this.products = []
				axios('/api/products')
				.then( response => {
					this.products = response.data.products
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
					return 'Ocurrió un error al listar los productos'
				}

				if(!this.productsList || this.productsList.length <= 0){
					return 'Sin productos disponibles'
				}
			},
			productsList() {
				if(this.type == 'A') {
					return this.products
				}
				return this.products.filter( product => {
					return product.definition.type == this.type
				})
			}
		},
		created() {
			this.get()
		}
	}
</script>