import List from '../components/birthdays/List.vue'
import Main from '../components/birthdays/Main.vue'

export default {
	path: '/celebraciones',
	component: Main,
	meta: {
		requiresAuth: true
	},
	children: [
		{
			path: '/',
			component: List
		}
	]
}