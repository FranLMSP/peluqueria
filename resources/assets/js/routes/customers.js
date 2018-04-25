import CustomersMain from '../components/customers/Main.vue'
import CustomersList from '../components/customers/List.vue'
import CustomersCreate from '../components/customers/Create.vue'
import Customer from '../components/customers/Show.vue'

export default {
	path: '/clientes',
	component: CustomersMain,
	meta: {
		requiresAuth: true
	},
	children: [
		{
			path: '/',
			component: CustomersList
		},
		{
			path: 'crear',
			component: CustomersCreate
		},
		{
			path: ':id',
			component: Customer
		}
	]
}