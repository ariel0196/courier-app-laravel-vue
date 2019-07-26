<template>
	<div class="animated fadeIn">
		<b-row class="justify-content-center">
			<b-col>
				<b-card>
					<!-- HEADER -->
					<div slot="header">
						<i class="fa fa-bars" />
						<strong>Listado de Departamentos</strong>
					</div>

					<!-- BOTON: AGREGAR -->
					<b-row>
						<b-col>
							<div class="pb-3">
								<b-button
									variant="primary"
									@click="showCrudModal()"
								>
									<i class="fa fa-plus" /> Agregar Departamento
								</b-button>
							</div>
						</b-col>
					</b-row>

					<!-- CONTENEDOR: FILTROS -->
					<b-row>
						<b-col md="2">
							<b-form-group>
								<b-form-select
									:options="[10, 15, 30]"
									v-model="table.perPage"
								/>
							</b-form-group>
						</b-col>

						<b-col
							md="4"
							offset-md="6"
						>
							<b-input-group class="mb-3">
								<b-input-group-text slot="prepend">
									<i class="fa fa-search" />
								</b-input-group-text>
								<b-input
									type="text"
									v-model="table.filter"
								/>
							</b-input-group>
						</b-col>
					</b-row>

					<!-- TABLA: DEPARTAMENTOS -->
					<b-row>
						<b-col>
							<b-table
								:items="tableItemsProvider"
								:fields="table.fields"
								:filter="table.filter"
								:per-page="table.perPage"
								:current-page="table.currentPage"
								ref="table"
								class="table-outline mb-3"
								head-variant="light"
								responsive
								striped
								hover
							>
								<template
									slot="acciones"
									slot-scope="row"
								>
									<b-button
										size="sm"
										class="mr-1"
										variant="primary"
										@click="showCrudModal(row)"
									>
										<i class="fa fa-edit" />
										Editar
									</b-button>
								</template>
							</b-table>
						</b-col>
					</b-row>

					<!-- CAMPO: PAGINACION -->
					<b-row>
						<b-col>
							<b-pagination
								:total-rows="table.totalRows"
								:per-page="table.perPage"
								v-model="table.currentPage"
							/>
						</b-col>
					</b-row>
				</b-card>
			</b-col>
		</b-row>

		<!-- MODAL: CRUD DEPARTAMENTO -->
		<crud-modal
			ref="crudModal"
			@remove="refreshTable()"
			@save="refreshTable()"
		/>
	</div>
</template>

<script>
import Proxy from '@/proxies/DepartamentoProxy';
import CrudModal from '@/components/modals/DepartamentoModal';
import ListPageMixin from '@/mixins/ListPageMixin';

export default {

	mixins: [ ListPageMixin ],

	components: { CrudModal },

	proxy: new Proxy(),

	data () {
		return {
			table: {
				fields: [
					{ key: 'id', sortable: true },
					{ key: 'nombre', sortable: true },
					{ key: 'descripcion', sortable: true },
					{ key: 'acciones', sortable: false }
				]
			}
		};
	}
};
</script>
