import Main from '../components/commissions/Main.vue'
import List from '../components/commissions/List.vue'
import Form from '../components/commissions/Form.vue'
import Show from '../components/commissions/Show.vue'

export default {
	path: '/comisiones',
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
			path: ':ids/editar',
			component: Form,
			meta: {
				mode: 'edit'
			}			
		}
	]
}