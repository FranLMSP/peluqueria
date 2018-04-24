import Home from './components/Home.vue'

import CostumersMain from './components/customers/Main.vue'
import CustomersList from './components/customers/List.vue'

import Login from './components/auth/Login.vue'

export const routes = [
	{
		path: '/',
		component: Home,
		meta: {
			requiresAuth: true
		}
	},
	{
		path: '/clientes',
		component: CostumersMain,
		meta: {
			requiresAuth: true
		},
		children: [
			{
				path: '/',
				component: CustomersList
			},
			/*{
				path: '/crear',
				component: CustomerCreate
			},
			{
				path: '/:id',
				component: Customer
			}*/
		]
	},
	{
		path: '/login',
		component: Login
	}
]