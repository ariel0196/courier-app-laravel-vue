const routes = [
	{
		path: '/',
		redirect: '/dashboard'
	},
	{
		path: '/dashboard',
		component: () => import('@/layouts/Dashboard'),
		meta: { breadcrumb: 'Dashboard', auth: true },
		redirect: '/dashboard/home',
		children: [
			{
				path: 'home',
				meta: { breadcrumb: 'Home' },
				component: () => import('@/pages/Home')
			},
			{
				path: 'cliente',
				meta: {	breadcrumb: 'Home' },
				component: () => import('@/pages/ClienteDashboard')
			},
			{
				path: 'envios',
				component: { name: 'envios', template: '<router-view/>' },
				meta: { breadcrumb: 'Envíos' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Envios')
					},
					{
						path: 'crear',
						meta: { breadcrumb: 'Crear Envío' },
						component:  () => import('@/pages/EnvioCrud')
					},
					{
						path: ':id/editar',
						meta: { breadcrumb: 'Editar Envío' },
						component: () => import('@/pages/EnvioCrud')
					}
				]
			},
			{
				path: 'facturas',
				component: { name: 'facturas', template: '<router-view/>' },
				meta: { breadcrumb: 'Facturas' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Facturas')
					},
					{
						path: 'crear',
						meta: { breadcrumb: 'Crear Factura' },
						component: () => import('@/pages/FacturaCrud')
					},
					{
						path: ':id/editar',
						meta: { breadcrumb: 'Editar Factura' },
						component: () => import('@/pages/FacturaCrud')
					}
				]
			},
			{
				path: 'clientes',
				component: { name: 'clientes', template: '<router-view/>' },
				meta: { breadcrumb: 'Clientes' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Clientes')
					}
				]
			},
			{
				path: 'repartidores',
				component: { name: 'repartidores', template: '<router-view/>' },
				meta: { breadcrumb: 'repartidores' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Repartidores')
					}
				]
			},
			{
				path: 'ciudades',
				component: { name: 'ciudades', template: '<router-view/>' },
				meta: { breadcrumb: 'Ciudades' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Ciudades')
					}
				]
			},
			{
				path: 'charts',
				component: {
					name: 'charts',
					template: '<router-view/>'
				},
				meta: {
					breadcrumb: 'Ciudades'
				},
				children: [
					{
						path: '',
						component: () => import('@/pages/Charts')
					}
				]
			},
			{
				path: 'usuarios',
				component: { name: 'usuarios', template: '<router-view/>' },
				meta: { breadcrumb: 'Usuarios' },
				children: [
					{
						path: '',
						component: () => import('@/pages/Usuarios')
					}
				]
			},
			{
				path: 'tipos_envios',
				component: { name: 'tipos_envios', template: '<router-view/>' },
				meta: { breadcrumb: 'Tipos de Envios' },
				children: [
					{
						path: '',
						component: () => import('@/pages/TiposEnvio')
					}
				]
			},
			{
				path: 'reporte_envios',
				component: { name: 'reporte_envios', template: '<router-view/>' },
				meta: { breadcrumb: 'Reporte de Envios' },
				children: [
					{
						path: '',
						component: () => import('@/pages/ReporteEnvios')
					}
				]
			},
			{
				path: 'reporte_facturas',
				component: { name: 'reporte_facturas', template: '<router-view/>' },
				meta: { breadcrumb: 'Reporte de Facturas' },
				children: [
					{
						path: '',
						component: () => import('@/pages/ReporteFacturas')
					}
				]
			}
		]
	},
	{
		path: '/login',
		name: 'Login',
		component: () => import('@/pages/Login')
	},
	{
		path: '/register',
		name: 'Register',
		component: () => import('@/pages/Register')
	},
	{
		path: '*',
		name: 'Page404',
		component: () => import('@/pages/Page404')
	}
];

export default routes;
