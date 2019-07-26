<script>
import { Bar } from 'vue-chartjs';
import Proxy from '@/proxies/FacturaProxy';

const proxy = new Proxy();

export default {
	extends: Bar,
	// eslint-disable-next-line vue/require-prop-types
	props: ['height'],
	async mounted () {
		// Overwriting base render method with actual data.
		let { data } = await proxy.chart();

		let labels = [];
		let values = {
			dentro: [],
			fuera: []
		};

		data.forEach(mes => {
			labels.push(mes.nombre);
			values.dentro.push(mes.dentro);
			values.fuera.push(mes.fuera);
		});

		// console.log(data);

		this.renderChart(
			{
				labels,
				datasets: [
					{
						label: 'Dentro de tiempo',
						backgroundColor: '#f87979',
						data: values.dentro
					},
					{
						label: 'Fuera de tiempo',
						backgroundColor: '#f87979',
						data: values.fuera
					}
				]
			},
			{
				maintainAspectRatio: false,
				scales: {
					yAxes: [
						{
							display: true,
							ticks:
							{
								beginAtZero: true
							}
						}
					]
				}
			}
		);
	}
};
</script>
