<template>
	<div :class="classList">
		<slot />
	</div>
</template>

<script>
export default {
	name: 'CoreCallout',
	props: {
		variant: {
			type: String,
			default: 'info'
		}
	},
	computed: {
		classList () {
			return [
				'callout',
				this.calloutVariant
			];
		},
		calloutVariant () {
			return this.variant ? `callout-${this.variant}` : '';
		}
	}
};
</script>
