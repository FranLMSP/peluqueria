import Main from '../components/companies/Main.vue'
import List from '../components/companies/List.vue'
import Form from '../components/companies/Form.vue'
import Show from '../components/companies/Show.vue'

export default {
	path: '/sucursales',
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
			path: 'crear',
			component: Form,
			meta: {
				mode: 'create'
			}
		},
		{
			path: ':id/editar',
			component: Form,
			meta: {
				mode: 'edit'
			}
		},
		{
			path: ':id',
			component: Show
		}
	]
}