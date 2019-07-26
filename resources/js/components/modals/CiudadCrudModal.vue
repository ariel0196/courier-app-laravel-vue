<template>
	<b-modal
		ref="modal"
		title="Ciudad"
	>
		<!-- FORMULARIO -->
		<b-form>
			<b-row>
				<b-col>
					<!-- CAMPO ID -->
					<b-form-group label="Id">
						<b-form-input
							v-model="model.id"
							name="id"
							readonly
						/>
					</b-form-group>

					<!-- CAMPO NOMBRE -->
					<b-form-group
						:invalid-feedback="errors.first('nombre')"
						label="Nombre"
					>
						<b-form-input
							v-model="model.nombre"
							v-validate="'required|alpha_spaces'"
							:state="errors.has('nombre') ? 'invalid' : null"
							name="nombre"
						/>
					</b-form-group>

					<!-- CAMPO DESCRIPCION -->
					<b-form-group label="Descripcion">
						<b-form-input
							v-model="model.descripcion"
							name="descripcion"
						/>
					</b-form-group>

					<!-- CAMPO DEPARTAMENTO  -->
					<b-form-group label="Departamento *">
						<departamento-select
							v-validate="'required'"
							:value="model.departamento"
							@input="dep => model.departamento_id = dep ? dep.id : null"
							name="departamento"
						/>
						<span
							v-text="errors.first('departamento')"
							class="invalid-feedback d-inline"
						/>
					</b-form-group>
				</b-col>
			</b-row>
		</b-form>

		<!-- FOOTER -->
		<template slot="modal-footer">
			<b-button
				variant="success"
				size="sm"
				@click="save()"
			>
				<i class="fa fa-save" />
				Guardar
			</b-button>

			<b-button
				variant="primary"
				size="sm"
				@click="cancel()"
			>
				<i class="fa fa-ban" />
				Cancelar
			</b-button>
		</template>
	</b-modal>
</template>

<script>
import CrudModalMixin from '@/mixins/CrudModalMixin';
import Proxy from '@/proxies/CiudadProxy';
import DepartamentoSelect from '@/components/selects/DepartamentoSelect';

export default {

	mixins: [ CrudModalMixin ],

	components: { DepartamentoSelect },

	proxy: new Proxy(),

	data () {
		return {
			model: {
				id: null,
				nombre: null,
				descripcion: null,
				departamento_id: null,
				departamento: { nombre: null }
			}
		};
	}
};
</script>
