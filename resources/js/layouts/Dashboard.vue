<template>
	<div class="app">
		<dashboard-header />
		<div class="app-body">
			<dashboard-sidebar :nav-items="nav" />
			<main class="main">
				<dashboard-breadcrumb :list="list" />
				<div class="container-fluid">
					<notifications />
					<router-view />
				</div>
			</main>
			<!-- <dashboard-aside></dashboard-aside> -->
		</div>
		<dashboard-footer />
	</div>
</template>

<script>
import DashboardHeader from './Dashboard/DashboardHeader';
import DashboardSidebar from './Dashboard/DashboardSidebar';
import DashboardBreadcrumb from './Dashboard/DashboardBreadcrumb';
import DashboardFooter from './Dashboard/DashboardFooter';
// import DashboardAside from './Dashboard/DashboardAside'
import nav from '@/common/nav';
import navCliente from '@/common/navCliente';

export default {
	name: 'Dashboard',
	components: {
		DashboardHeader,
		DashboardSidebar,
		DashboardBreadcrumb,
		DashboardFooter
		// DashboardAside
	},
	created () {
		if (localStorage.getItem('user')) {
			let user = JSON.parse(localStorage.getItem('user'));
			if (user.rol == 'cliente') return this.nav = navCliente.items;
		}
		this.nav = nav.items;

	},
	data () {
		return {
			nav: []
		};
	},
	computed: {
		name () {
			return this.$route.name;
		},
		list () {
			return this.$route.matched;
		}
	}
};
</script>
