<template>
	<div>
		<b-table
			:items="items"
			:fields="fields"
			:show-empty="true"
			outlined
			head-variant="light"
		>
			<template
				slot="ciudad.nombre"
				slot-scope="row"
			>
				<ciudad-select
					:value="row.item.ciudad"
					@input="ciudad => changeCiudad(ciudad, row.item)"
					:disabled="editingRow !== row.index"
				/>
			</template>

			<template
				slot="descripcion"
				slot-scope="row"
			>
				<b-form-input
					v-model="row.item.descripcion"
					:disabled="editingRow !== row.index"
					class="w-100"
				/>
			</template>

			<template
				slot="acciones"
				slot-scope="row"
			>
				<b-button
					v-if="editingRow !== row.index"
					@click="setEditingRow(row.index)"
					variant="primary"
				>
					<i class="fa fa-edit" />
				</b-button>
				<b-button
					v-else
					@click="setEditingRow(row.index)"
					variant="success"
				>
					<i class="fa fa-check" />
					<!-- Guardar -->
				</b-button>
				<b-button
					v-if="editingRow !== row.index"
					@click="removeRow(row.index)"
					variant="danger"
				>
					<i class="fa fa-trash" />
					<!-- Eliminar -->
				</b-button>
			</template>
		</b-table>

		<b-button
			variant="success"
			size="sm"
			@click="addRow()"
		>
			<i class="fa fa-plus" />
			Agregar Dirección
		</b-button>
	</div>
</template>


<script>
import CiudadSelect from '@/components/selects/CiudadSelect';

export default {
	components: { CiudadSelect },
	props: {
		items: {
			type: Array,
			default: () => [],
		}
	},
	data () {
		return {
			fields: [
				{ key: 'descripcion', label: 'Descripcion' },
				{ key: 'ciudad.nombre', label: 'Ciudad'},
				{ key: 'acciones', class: 'text-center' }
			],
			editingRow: null
		};
	},
	methods: {
		setEditingRow (index) {
			this.editingRow = this.editingRow === index ? null : index;
		},
		addRow () {
			this.items.push({
				id: null,
				ciudad: { nombre: null, id: null },
				descripcion: null
			});
			this.setEditingRow(this.items.length - 1);
		},
		removeRow (index) {
			if (!confirm('Desea eliminar el registro?')) return;
			this.$delete(this.items, index);
		},
		//
		changeCiudad (ciudad, item) {
			if (ciudad == null) return;
			item.ciudad_id = ciudad.id;
			item.ciudad = ciudad;
		}
	}
};
</script>
