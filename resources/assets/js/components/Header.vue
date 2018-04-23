<template>
	<header>

		<nav class="navbar bg-dark navbar-dark">
		  <div class="container">
		  	
			<!-- Brand/logo -->
			<router-link class="navbar-brand" to="/">Peluqueria</router-link>

			<!-- Links -->
			<ul class="navbar-nav">
				<template v-if="!currentUser">
					<li class="nav-item">
						<router-link class="nav-link" to="/login">Iniciar sesión</router-link>
 					</li>
					<li class="nav-item">
						<router-link class="nav-link" to="/register">Registrarse</router-link>
 					</li>
				</template>

				<template v-else>
					<li class="nav-item">
						<router-link class="nav-link" to="/clientes">Clientes</router-link>
					</li>

					<li class="nav-item dropdown">
						<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" aria-expanded="false" data-toggle="dropdown" aria-haspopup="true" >
							{{ currentUser.name }} <span class="caret"></span>
						</a>

						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<a href="#" @click.prevent="logout" class="dropdpwn-item">Salir</a>
						</div>
					</li>
				</template>
			</ul>
		  </div>
		</nav>
	</header>
</template>

<script type="text/javascript">
	export default {
		name: 'app-header',
		data() {
			return {

			}
		},
		methods: {
			logout() {
				this.$store.commit('logout')
				this.$router.push('/login')
			}
		},
		computed: {
			currentUser() {
				return this.$store.getters.currentUser
			}
		}
	}
</script>