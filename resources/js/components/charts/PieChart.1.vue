<script>
import { Pie } from 'vue-chartjs';
import Proxy from '@/proxies/EnvioProxy';

const proxy = new Proxy();

export default {
	extends: Pie,
	// eslint-disable-next-line vue/require-prop-types
	props: ['height'],

	async mounted () {
		// Overwriting base render method with actual data.
		let { data } = await proxy.chart();

		let labels = [];
		let values = [];

		data.forEach(item => {
			labels.push(item.estado);
			values.push(item.total);
		});

		console.log(data);

		this.renderChart({
			labels,
			datasets: [
				{
					backgroundColor: [
						'#41B883',
						'#E46651',
						'#00D8FF',
						'#DD1B16'
					],
					data: values
				}
			]
		}, {responsive: true, maintainAspectRatio: false});
	}
};
</script>
