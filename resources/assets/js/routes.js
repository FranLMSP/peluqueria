import Home from './components/Home.vue'


import CustomersRoutes from './routes/customers'
import ProvidersRoutes from './routes/providers'
import ProductsRoutes from './routes/products'
import EmployeesRoutes from './routes/employees'

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
	ProvidersRoutes,
	ProductsRoutes,
	EmployeesRoutes

]