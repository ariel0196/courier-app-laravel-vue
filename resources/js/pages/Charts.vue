<template>
	<div class="animated fadeIn">
		<b-card-group
			columns
			class="card-columns cols-2"
		>
			<b-card header="Line Chart">
				<div class="chart-wrapper">
					<line-example />
				</div>
			</b-card>
			<b-card header="Bar Chart">
				<div class="chart-wrapper">
					<bar-example />
				</div>
			</b-card>
			<b-card header="Doughnut Chart">
				<div class="chart-wrapper">
					<doughnut-example />
				</div>
			</b-card>
			<b-card header="Radar Chart">
				<div class="chart-wrapper">
					<radar-example />
				</div>
			</b-card>
			<b-card header="Pie Chart">
				<div class="chart-wrapper">
					<pie-example />
				</div>
			</b-card>
			<b-card header="Polar Area Chart">
				<div class="chart-wrapper">
					<polar-area-example />
				</div>
			</b-card>
		</b-card-group>
	</div>
</template>
<script>
import BarExample from '@/components/charts/BarChart';
import PieExample from '@/components/charts/PieChart';
import LineExample from './Charts/LineExample';
import DoughnutExample from './Charts/DoughnutExample';
import RadarExample from './Charts/RadarExample';
import PolarAreaExample from './Charts/PolarAreaExample';

export default {
	name: 'Charts',
	components: {
		BarExample,
		LineExample,
		DoughnutExample,
		RadarExample,
		PieExample,
		PolarAreaExample
	}
};
</script>
