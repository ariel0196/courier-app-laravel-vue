<template>
	<ol class="breadcrumb">
		<li
			class="breadcrumb-item"
			v-for="(item, index) in filteredList"
			:key="index"
		>
			<span
				class="active"
				v-if="isLast(index)"
			>
				{{ showName(item) }}
			</span>
			<router-link
				:to="item"
				v-else
			>
				{{ showName(item) }}
			</router-link>
		</li>
	</ol>
</template>

<script>
export default {
	name: 'DashboardBreadcrumb',
	props: {
		list: {
			type: Array,
			required: true,
			default: () => []
		}
	},
	computed: {
		filteredList () {
			let list = this.list;
			/* eslint eqeqeq: "off" */
			let filtered = list.filter(item => item.meta.breadcrumb != ('undefined' && null));
			return filtered;
		}
	},
	methods: {
		isLast (index) {
			return index === this.filteredList.length - 1;
		},
		showName (item) {
			// if (item.meta && item.meta.label) {
			// 	item = item.meta && item.meta.label
			// }
			// if (item.name) {
			// 	item = item.name
			// }

			return item.meta.breadcrumb;
		}
	}
};
</script>
