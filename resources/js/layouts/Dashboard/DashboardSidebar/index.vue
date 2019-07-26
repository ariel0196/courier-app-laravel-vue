<template>
	<div class="sidebar">
		<!-- <sidebar-header></sidebar-header> -->

		<!-- <sidebar-form></sidebar-form> -->

		<nav class="sidebar-nav">
			<div slot="header" />

			<ul class="nav">
				<template v-for="(item, key) in navItems">
					<template v-if="item.title">
						<sidebar-nav-title
							:name="item.name"
							:classes="item.class"
							:wrapper="item.wrapper"
							:key="key"
						/>
					</template>
					<template v-else-if="item.divider">
						<sidebar-nav-divider
							:classes="item.class"
							:key="key"
						/>
					</template>
					<template v-else-if="item.label">
						<sidebar-nav-label
							:name="item.name"
							:url="item.url"
							:icon="item.icon"
							:label="item.label"
							:classes="item.class"
							:key="key"
						/>
					</template>
					<template v-else>
						<template v-if="item.children">
							<!-- First level dropdown -->
							<sidebar-nav-dropdown
								:name="item.name"
								:url="item.url"
								:icon="item.icon"
								:key="key"
							>
								<template v-for="(childL1, key2) in item.children">
									<template v-if="childL1.children">
										<!-- Second level dropdown -->
										<sidebar-nav-dropdown
											:name="childL1.name"
											:url="childL1.url"
											:icon="childL1.icon"
											:key="key2"
										>
											<li
												class="nav-item"
												v-for="(childL2, key3) in childL1.children"
												:key="key3"
											>
												<sidebar-nav-link
													:name="childL2.name"
													:url="childL2.url"
													:icon="childL2.icon"
													:badge="childL2.badge"
													:variant="item.variant"
												/>
											</li>
										</sidebar-nav-dropdown>
									</template>
									<template v-else>
										<sidebar-nav-item
											:classes="item.class"
											:key="key2"
										>
											<sidebar-nav-link
												:name="childL1.name"
												:url="childL1.url"
												:icon="childL1.icon"
												:badge="childL1.badge"
												:variant="item.variant"
											/>
										</sidebar-nav-item>
									</template>
								</template>
							</sidebar-nav-dropdown>
						</template>
						<template v-else>
							<sidebar-nav-item
								:classes="item.class"
								:key="key"
							>
								<sidebar-nav-link
									:name="item.name"
									:url="item.url"
									:icon="item.icon"
									:badge="item.badge"
									:variant="item.variant"
								/>
							</sidebar-nav-item>
						</template>
					</template>
				</template>
			</ul>

			<slot />
		</nav>
		<SidebarFooter />
		<SidebarMinimizer />
	</div>
</template>

<script>
import SidebarFooter from './SidebarFooter';
// import SidebarForm from './SidebarForm';
// import SidebarHeader from './SidebarHeader';
import SidebarMinimizer from './SidebarMinimizer';
import SidebarNavDivider from './SidebarNavDivider';
import SidebarNavDropdown from './SidebarNavDropdown';
import SidebarNavLink from './SidebarNavLink';
import SidebarNavTitle from './SidebarNavTitle';
import SidebarNavItem from './SidebarNavItem';
import SidebarNavLabel from './SidebarNavLabel';

export default {
	name: 'DashboardSidebar',
	props: {
		navItems: {
			type: Array,
			required: true,
			default: () => []
		}
	},
	components: {
		SidebarFooter,
		// SidebarForm,
		// SidebarHeader,
		SidebarMinimizer,
		SidebarNavDivider,
		SidebarNavDropdown,
		SidebarNavLink,
		SidebarNavTitle,
		SidebarNavItem,
		SidebarNavLabel
	},
	methods: {
		handleClick (e) {
			e.preventDefault();
			e.target.parentElement.classList.toggle('open');
		}
	}
};
</script>

<style lang="css">
	.nav-link {
		cursor:pointer;
	}
</style>
