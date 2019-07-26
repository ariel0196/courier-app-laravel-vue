<template>
	<b-alert
		dismissible
		:show="countDown"
		@dismiss-count-down="actualTime => this.countDown = actualTime"
		:variant="item.variant"
		@dismissed="dismissed"
	>
		{{ item.message }}
		<!-- <b-progress :max="item.duration" :value="countDown" height="2px" :variant="item.variant"/> -->
	</b-alert>
</template>

<script>
export default {
	// eslint-disable-next-line vue/require-prop-types
	props: ['item'],

	data () {
		return {
			countDown: this.item.duration
		};
	},

	methods: {
		dismissed () {
			this.$emit('dismissed', this.item);
		}
	}
};
</script>
