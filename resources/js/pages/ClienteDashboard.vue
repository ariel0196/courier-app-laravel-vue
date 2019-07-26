<template>
	<div class="animated fadeIn">
		<b-row>
			<!-- WAVE CHART -->
			<b-col>
				<b-card>
					<b-row>
						<b-col sm="5">
							<h4
								id="traffic"
								class="card-title mb-0">Frecuencia de Envíos</h4>
							<div class="small text-muted">2019</div>
						</b-col>
						<b-col
							sm="7"
							class="d-none d-md-block">
							<b-button
								type="button"
								variant="primary"
								class="float-right">
								<i class="icon-cloud-download"/>
							</b-button>
							<b-button-toolbar
								class="float-right"
								aria-label="Toolbar with buttons group">
								<b-form-radio-group
									id="radiosBtn"
									class="mr-3"
									buttons
									button-variant="outline-secondary"
									name="radiosBtn">
									<b-form-radio
										class="mx-0"
										value="Day">
										Day
									</b-form-radio>
									<b-form-radio
										class="mx-0"
										value="Month">
										Month
									</b-form-radio>
									<b-form-radio
										class="mx-0"
										value="Year">
										Year
									</b-form-radio>
								</b-form-radio-group>
							</b-button-toolbar>
						</b-col>
					</b-row>
					<home-main-chart
						class="chart-wrapper mt-4"
						style="height: 300px"
						height="300"/>
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
import HomeMainChart from './ClienteDashboard/ClienteDashboardChart';
import Proxy from '@/proxies/ClienteProxy';
let proxy = new Proxy();

export default {
	name: 'Home',
	components: {
		HomeMainChart
	},
	data() {
		return {
			table: {
				fields: [
					{	key: 'id',	sortable: true	},
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

			if (!localStorage.getItem('user')) return [];

			let user = JSON.parse(localStorage.getItem('user'));
			try {

				let {data, meta} = await proxy.envios(user.cliente_id);
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
