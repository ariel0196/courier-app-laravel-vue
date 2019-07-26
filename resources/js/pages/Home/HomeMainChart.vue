<script>
import { Line } from 'vue-chartjs';
import Proxy from '@/proxies/FacturaProxy';

const proxy = new Proxy();

export default {
	extends: Line,
	// eslint-disable-next-line vue/require-prop-types
	props: ['height'],
	async mounted () {

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

		this.renderChart({
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
		}, {
			maintainAspectRatio: false,
			scales: {

				yAxes: [{
					ticks: {
						beginAtZero: true
					},
					gridLines: {
						display: true
					}
				}]
			},
			elements: {
				point: {
					radius: 0,
					hitRadius: 10,
					hoverRadius: 4,
					hoverBorderWidth: 3
				}
			}
		});
	}
};
</script>
