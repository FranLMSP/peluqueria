import Home from './components/Home.vue'

import CustomersMain from './components/customers/Main.vue'
import CustomersList from './components/customers/List.vue'
import CustomersCreate from './components/customers/Create.vue'
import Customer from './components/customers/Show.vue'

import Login from './components/auth/Login.vue'

export const routes = [
	{
		path: '/login',
		component: Login
	},
	{
		path: '/',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
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
	},

]