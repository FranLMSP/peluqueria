import Main from '../components/products/Main.vue'
import List from '../components/products/List.vue'
import Form from '../components/products/Form.vue'
import Show from '../components/products/Show.vue'

export default {
	path: '/productos',
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