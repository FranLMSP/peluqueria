import Main from '../components/customers/Main.vue'
import List from '../components/customers/List.vue'
import Form from '../components/customers/Form.vue'
import Show from '../components/customers/Show.vue'

export default {
	path: '/clientes',
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