// eslint-disable-next-line no-restricted-syntax
export default [
	{
		_tag: 'CSidebarNavItem',
		name: 'Главная',
		to: '/dashboard',
		icon: 'cil-speedometer',
	},
	{
		_tag: 'CSidebarNavTitle',
		_children: ['Командировка'],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Отчетные документы',
		to: '/trip/document',
		icon: 'cil-description',
	},
	{
		_tag: 'CSidebarNavTitle',
		_children: ['Войсковые части'],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Список частей',
		to: '/military_units/lists',
		icon: 'cil-home',
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Неисправности',
		to: '/military_units/defects',
		icon: 'cil-x-circle',
	},
	{
		_tag: 'CSidebarNavDropdown',
		name: 'Buttons',
		route: '/buttons',
		icon: 'cil-cursor',
		_children: [
			{
				_tag: 'CSidebarNavItem',
				name: 'Buttons',
				to: '/buttons/buttons',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Brand buttons',
				to: '/buttons/brand-buttons',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Buttons groups',
				to: '/buttons/button-groups',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Dropdowns',
				to: '/buttons/button-dropdowns',
			},
		],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Charts',
		to: '/charts',
		icon: 'cil-chart-pie',
	},
	{
		_tag: 'CSidebarNavDropdown',
		name: 'Icons',
		route: '/icons',
		icon: 'cil-star',
		_children: [
			{
				_tag: 'CSidebarNavItem',
				name: 'CoreUI Free',
				to: '/icons/coreui-icons',
				badge: {
					color: 'success',
					text: 'NEW',
				},
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'CoreUI Flags',
				to: '/icons/flags',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'CoreUI Brands',
				to: '/icons/brands',
			},
		],
	},
	{
		_tag: 'CSidebarNavDropdown',
		name: 'Notifications',
		route: '/notifications',
		icon: 'cil-bell',
		_children: [
			{
				_tag: 'CSidebarNavItem',
				name: 'Alerts',
				to: '/notifications/alerts',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Badges',
				to: '/notifications/badges',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Modal',
				to: '/notifications/modals',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Toaster',
				to: '/notifications/toaster',
			},
		],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Widgets',
		to: '/widgets',
		icon: 'cil-calculator',
		badge: {
			color: 'info',
			text: 'NEW',
		},
	},
	{
		_tag: 'CSidebarNavDivider',
	},
	{
		_tag: 'CSidebarNavTitle',
		_children: ['Extras'],
	},
	{
		_tag: 'CSidebarNavDropdown',
		name: 'Pages',
		route: '/pages',
		icon: 'cil-star',
		_children: [
			{
				_tag: 'CSidebarNavItem',
				name: 'Login',
				to: '/login',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Register',
				to: '/register',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Error 404',
				to: '/404',
			},
			{
				_tag: 'CSidebarNavItem',
				name: 'Error 500',
				to: '/500',
			},
		],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Disabled',
		icon: 'cil-ban',
		badge: {
			color: 'secondary',
			text: 'NEW',
		},
		addLinkClass: 'c-disabled',
		disabled: true,
	},
	{
		_tag: 'CSidebarNavDivider',
		className: 'm-2',
	},
	{
		_tag: 'CSidebarNavTitle',
		_children: ['Labels'],
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Label danger',
		to: '',
		icon: {
			name: 'cil-star',
			className: 'text-danger',
		},
		label: true,
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Label info',
		to: '',
		icon: {
			name: 'cil-star',
			className: 'text-info',
		},
		label: true,
	},
	{
		_tag: 'CSidebarNavItem',
		name: 'Label warning',
		to: '',
		icon: {
			name: 'cil-star',
			className: 'text-warning',
		},
		label: true,
	},
	{
		_tag: 'CSidebarNavDivider',
		className: 'm-2',
	},
];
