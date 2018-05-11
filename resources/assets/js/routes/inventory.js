import Main from '../components/inventory/Main.vue'
import List from '../components/inventory/List.vue'
import Ingress from '../components/inventory/Ingress.vue'

import SalesMain from '../components/inventory/sales/Main.vue'
import SalesList from '../components/inventory/sales/List.vue'
import SalesShow from '../components/inventory/sales/Show.vue'
import SalesForm from '../components/inventory/sales/Form.vue'

export default {
	path: '/inventario',
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
			path: 'ingresar',
			component: Ingress
		},
		{
			path: 'ventas',
			component: SalesMain,
			meta: {
				requiresAuth: true
			},
			children: [
				{
					path: '/',
					component: SalesList
				},
				{
					path: 'nueva',
					component: SalesForm,
					meta: {
						mode: 'create'
					}
				},
				{
					path: ':id',
					component: SalesShow
				},
			],
		}
	]
}