import Main from '../components/calendar/Main.vue'
import Calendar from '../components/calendar/Calendar.vue'

export default {
	path: '/agenda',
	component: Main,
	meta: {
		requiresAuth: true
	},
	children: [
		{
			path: '/',
			component: Calendar
		},
	]
}