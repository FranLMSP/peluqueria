import Home from './components/Home.vue'


import CustomersRoutes from './routes/customers'
import ProvidersRoutes from './routes/providers'
import ProductsRoutes from './routes/products'
import EmployeesRoutes from './routes/employees'
import InventoryRoutes from './routes/inventory'
import CommissionsRoutes from './routes/commissions'
import BirthdaysRoutes from './routes/birthdays'
import CompaniesRoutes from './routes/companies'

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
		path: '/login',
		component: Login
	},
	CustomersRoutes,
	ProvidersRoutes,
	ProductsRoutes,
	EmployeesRoutes,
	InventoryRoutes,
	CommissionsRoutes,
	BirthdaysRoutes,
	CompaniesRoutes,

]