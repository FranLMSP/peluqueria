import Main from '../components/employees/Main.vue'
import List from '../components/employees/List.vue'
import Form from '../components/employees/Form.vue'
import Show from '../components/employees/Show.vue'

export default {
	path: '/empleados',
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