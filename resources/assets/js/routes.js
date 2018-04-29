import Home from './components/Home.vue'


import CustomersRoutes from './routes/customers'
import ProductsRoutes from './routes/products'

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
	CustomersRoutes,
	ProductsRoutes

]