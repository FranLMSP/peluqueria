import Main from '../components/inventory/Main.vue'
import List from '../components/inventory/List.vue'
import Ingress from '../components/inventory/Ingress.vue'

export default {
	path: '/inventario',
	component: Main,
	meta: {
		requiresAuth: true
	},
	children: [
		{
			path: '/',
			component: List
		},
		{
			path: 'ingresar',
			component: Ingress
		},

	]
}