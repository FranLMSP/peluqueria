import Main from '../components/mails/Main.vue'
import List from '../components/mails/List.vue'
import Form from '../components/mails/Form.vue'
import Show from '../components/mails/Show.vue'

export default {
	path: '/correos',
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
			path: ':id',
			component: Show
		}
	]
}