<template>
	<header class="app-header navbar">
		<button
			class="navbar-toggler mobile-sidebar-toggler d-lg-none"
			type="button"
			@click="mobileSidebarToggle"
		>
			<span class="navbar-toggler-icon" />
		</button>

		<b-link
			class="navbar-brand"
			to="/"
		/>

		<button
			class="navbar-toggler sidebar-toggler d-md-down-none"
			type="button"
			@click="sidebarToggle"
		>
			<span class="navbar-toggler-icon" />
		</button>

		<b-navbar-nav class="d-md-down-none">
			<router-link
				class="nav-link px-3"
				to="/dashboard/envios"
			>
				Envios
			</router-link>
			<router-link
				class="nav-link px-3"
				to="/dashboard/facturas"
			>
				Facturas
			</router-link>
			<router-link
				class="nav-link px-3"
				to="/dashboard/clientes"
			>
				Clientes
			</router-link>
		</b-navbar-nav>

		<b-navbar-nav class="ml-auto">
			<b-nav-item class="d-md-down-none">
				Bienvenido <strong>{{ username }}</strong>
			</b-nav-item>

			<!-- <b-nav-item class="d-md-down-none">
				<i class="icon-bell"></i>
				<b-badge pill variant="danger">5</b-badge>
			</b-nav-item>

			<b-nav-item class="d-md-down-none">
				<i class="icon-location-pin"></i>
			</b-nav-item> -->

			<header-dropdown />
		</b-navbar-nav>

		<!-- <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" @click="asideToggle">
			<span class="navbar-toggler-icon"></span>
		</button> -->
	</header>
</template>
<script>
import HeaderDropdown from './HeaderDropdown.vue';

export default {
	name: 'DashboardHeader',
	components: {
		HeaderDropdown
	},
	//
	computed: {
		username () {
			if (!localStorage.getItem('user')) return 'Usuario';
			let user = JSON.parse(localStorage.getItem('user'));
			return user.nombre;
		}
	},
	//
	methods: {
		sidebarToggle (e) {
			e.preventDefault();
			document.body.classList.toggle('sidebar-hidden');
		},
		sidebarMinimize (e) {
			e.preventDefault();
			document.body.classList.toggle('sidebar-minimized');
		},
		mobileSidebarToggle (e) {
			e.preventDefault();
			document.body.classList.toggle('sidebar-mobile-show');
		}
		// ,
		// asideToggle (e) {
		// 	e.preventDefault()
		// 	document.body.classList.toggle('aside-menu-hidden')
		// }
	}
};
</script>
