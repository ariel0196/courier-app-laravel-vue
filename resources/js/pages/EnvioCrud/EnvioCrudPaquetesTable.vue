<template>
	<div>
		<b-table
			:items="items"
			:fields="fields"
			:show-empty="true"
			outlined
			head-variant="light"
		>
			<!-- COLUMNA: Nombre -->
			<template
				slot="nombre"
				slot-scope="row"
			>
				<b-form-input
					v-model="row.item.nombre"
					:disabled="editingRow !== row.index"
					type="text"
					class="w-100"
				/>
			</template>

			<!-- COLUMNA: Tipo paquete -->
			<template
				slot="tipo_paquete"
				slot-scope="row"
			>
				<b-select
					:options="tiposPaquete"
					v-model="row.item.tipo_paquete"
					:disabled="editingRow !== row.index"
				/>
			</template>

			<!-- COLUMNA: Peso kg -->
			<template
				slot="peso_kg"
				slot-scope="row"
			>
				<b-form-input
					v-model="row.item.peso_kg"
					:disabled="editingRow !== row.index"
					type="text"
					class="w-100"
				/>
			</template>

			<!-- COLUMNA: Acciones -->
			<template
				slot="acciones"
				slot-scope="row"
			>
				<!-- BOTON: Editar -->
				<b-button
					v-if="editingRow !== row.index"
					@click="setEditingRow(row.index)"
					:disabled="disabled"
					variant="primary"
				>
					<i class="fa fa-edit" />
				</b-button>

				<!-- BOTON: Guardar -->
				<b-button
					v-else
					@click="setEditingRow(row.index)"
					variant="success"
				>
					<i class="fa fa-check" />
				</b-button>

				<!-- BOTON: Eliminar -->
				<b-button
					v-if="editingRow !== row.index"
					:disabled="disabled"
					@click="removeRow(row.index)"
					variant="danger"
				>
					<i class="fa fa-trash" />
				</b-button>
			</template>
		</b-table>
	</div>
</template>


<script>
// import CiudadSelect from '@/components/selects/CiudadSelect';
import { tiposPaquete } from '@/common/data';

export default {
	// components: { CiudadSelect },
	props: {
		items: {
			type: Array,
			default: () => [],
		},
		disabled: {
			type: Boolean,
			default: false
		}
	},
	data () {
		return {
			editingRow: null,
			fields: [
				{ key: 'nombre' },
				{ key: 'tipo_paquete' },
				{ key: 'peso_kg' },
				{ key: 'acciones', class: 'text-center' }
			],
			tiposPaquete
		};
	},
	methods: {
		setEditingRow (index) {
			this.editingRow = this.editingRow === index ? null : index;
		},
		addRow () {
			this.items.push({
				nombre: null,
				tipo_paquete: 'caja',
				peso_kg: 0
			});
			this.setEditingRow(this.items.length - 1);
		},
		removeRow (index) {
			if (!confirm('Desea eliminar el paquete?')) return;
			this.$delete(this.items, index);
		}
	}
};
</script>
