<template>
	<b-row>
		<b-col>
			<notification 
				v-for="(item, key) in items" 
				:item="item" 
				:key="key" 
				@dismissed="removeItem(item)"
			/> 
		</b-col>
	</b-row>
</template>

<script>
import Notification from './Notification';

export default {

	data () {
		return {
			items: []
		};
	},

	components: { 
		Notification 
	},

	methods: {
		removeItem (item) {
			let key = this.items.indexOf(item);
			if (key >= 0) {
				this.items.splice(key, 1);
			}
		}
	},

	created () {
		this.items = this.$notify.getItems();
	}
};
</script>

<style>
	.list-enter-active,
	.list-leave-active {
		transition: opacity .5s
	}

	.list-enter,
	.list-leave-active {
		opacity: 0;
	}
</style>
