<template>
	<div class="animated fadeIn">
		<b-row>
			<!-- CARD: CANT. CLIENTES REGISTRADOS  -->
			<b-col>
				<b-card
					no-body
					class="bg-primary"
				>
					<b-card-body class="pb-0">
						<h4 class="mb-0">
							8
						</h4>
						<p>Clientes registrados</p>
					</b-card-body>
					<home-card-line1-chart
						class="chart-wrapper px-3"
						style="height:70px;"
						height="70"
					/>
				</b-card>
			</b-col>

			<!-- CARD: CANT. ENVIOS PROCESADOS  -->
			<b-col>
				<b-card
					no-body
					class="bg-info"
				>
					<b-card-body class="pb-0">
						<h4 class="mb-0">
							12
						</h4>
						<p>Envios realizados</p>
					</b-card-body>
					<home-card-line2-chart
						class="chart-wrapper px-3"
						style="height:70px;"
						height="70"
					/>
				</b-card>
			</b-col>

			<!-- CARD: CANT. FACTURAS COBRADAS  -->
			<b-col>
				<b-card
					no-body
					class="bg-warning"
				>
					<b-card-body class="pb-0">
						<h4 class="mb-0">
							8
						</h4>
						<p>Facturas Cobradas</p>
					</b-card-body>
					<home-card-line3-chart
						class="chart-wrapper"
						style="height:70px;"
						height="70"
					/>
				</b-card>
			</b-col>
		</b-row>

		<b-row>
			<!-- BAR CHART -->
			<b-col>
				<b-card>
					<b-col sm="5">
						<h4
							id="traffic"
							class="card-title mb-0"
						>
							Facturas Cobradas por Mes
						</h4>
						<div class="small text-muted">
							2019
						</div>
					</b-col>
					<bar-chart
						class="chart-wrapper mt-4"
						style="height: 300px"
						height="300"
					/>
				</b-card>
			</b-col>

			<!-- PIE CHART -->
			<b-col>
				<b-card>
					<b-col>
						<h4
							id="traffic"
							class="card-title mb-0"
						>
							Envios realizados
						</h4>
						<div class="small text-muted">
							Portentaje % de envios realizados dentro y fuera del tiempo estimado
						</div>
					</b-col>
					<pie-chart
						class="chart-wrapper mt-4"
						style="height: 300px"
						height="300"
					/>
				</b-card>
			</b-col>
		</b-row>

		<!-- TABLA  -->
		<b-row>
			<b-col md="12">
				<b-card title="Envios Recientes">
					<hr>
					<b-card-body>
						<b-table
							:items="tableItemsProvider"
							:fields="table.fields"
							head-variant="light"
							striped
							responsive
							hover
							class="mb-0 table-outline"
						>
							<template
								slot="estado"
								slot-scope="row"
							>
								<b-badge :variant="estadoColVariant(row)">
									{{ row.item.estado }}
								</b-badge>
							</template>
						</b-table>
					</b-card-body>
				</b-card>
			</b-col>
		</b-row>
	</div>
</template>

<script>
import HomeCardLine1Chart from './Home/HomeCardLine1Chart';
import HomeCardLine2Chart from './Home/HomeCardLine2Chart';
import HomeCardLine3Chart from './Home/HomeCardLine3Chart';
import BarChart from '@/components/charts/BarChart';
import PieChart from '@/components/charts/PieChart';

import Proxy from '@/proxies/EnvioProxy';
let proxy = new Proxy();

export default {
	name: 'Home',
	components: {
		HomeCardLine1Chart,
		HomeCardLine2Chart,
		HomeCardLine3Chart,
		BarChart,
		PieChart
	},
	data() {
		return {
			table: {
				fields: [
					{	key: 'id',	sortable: true	},
					{	key: 'factura.numero',	sortable: true,	class: 'text-center',	label: 'No. Factura',	formatter: v => v || '-'},
					{	key: 'cliente_origen.nombre',	sortable: true },
					{	key: 'cliente_destino.nombre',sortable: true },
					{	key: 'estado', sortable: true, class: 'text-center'},
					{ key: 'fecha_creacion', sortable: true, class: 'text-center' },
					{ key: 'fecha_entrega', sortable: true, class: 'text-center' },
					{ key: 'tipo_envio.nombre', sortable: true, class: 'text-center' },
					{ key: 'precio_total', sortable: true, class: 'text-right' }
				]
			}
		};
	},

	methods: {

		estadoColVariant (row) {
			return {
				'pendiente': 'danger',
				'entregado': 'warning',
				'facturado': 'primary',
				'finalizado': 'success'
			}[row.item.estado];
		},

		async tableItemsProvider (ctx) {
			proxy.setParameters({
				'per_page': 5,
				'page': ctx.currentPage
			});
			try {
				let {data, meta} = await proxy.all();
				this.table.totalRows = meta.total;
				return data || [];
			} catch (e) {
				// this.isBusy = false;
				return [];
			}
		}
	}
};
</script>
