import Main from '../components/providers/Main.vue'
import List from '../components/providers/List.vue'
import Form from '../components/providers/Form.vue'
import Show from '../components/providers/Show.vue'

export default {
	path: '/proveedores',
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