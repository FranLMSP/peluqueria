<template>
	<div class="login row justify-content-center">
		<div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<p>Inicio de sesión</p>
				</div>

				<div class="card-body">
					<form @submit.prevent="authenticate">
						<div class="row form-group ">
							<label for="email"></label>
							<input type="email" class="form-control" placeholder="Email Address" v-model="form.email">
						</div>

						<div class="row form-group ">
							<label for="password"></label>
							<input type="password" class="form-control" placeholder="Password" v-model="form.password">
						</div>

						<div class="row form-group">
							<input type="submit" value="Login">
						</div>

						<div class="row form-group" v-if="authError">
							<p class="error">
								{{ authError }}
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</template>

<script type="text/javascript">
	
	import {login} from '../../helpers/auth.js'

	export default {
		data() {
			return {
				form: {
					email: '',
					password: ''
				},
				error: null
			}
		},
		methods: {
			authenticate() {
				this.$store.dispatch('login')

				login(this.form)
					.then( res => {
						this.$store.commit('loginSuccess', res)
						this.$router.push({path: '/'})
					})
					.catch( err => {
						this.$store.commit('loginFailed', {err})
					})
			}
		},
		computed: {
			authError() {
				return this.$store.getters.authError
			}
		}
	}

</script>

<style type="text/css">
	.error {
		text-align: center;
		color: red;
	}
</style>