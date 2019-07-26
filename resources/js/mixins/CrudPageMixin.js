import CrudMixin from './CrudMixin';

export default {

	mixins: [ CrudMixin ],

	async created () {
		try {

			await this.$_fetch(this.$route.params.id);

		} catch (e) {
			alert('Error al obtener el registro');
		}
	},

	methods: {

		cancel () { this.$router.back(); },

		async save () {
			try {

				if(!await this.$_save()) return;// alert('Error en el formulario')
				if (!confirm('Registro guardado correctamente. Desea seguir editando?'))
					this.$router.back();

			} catch (e) {
				alert(e.response.data ? e.response.data.error : 'Error en la peticion.');
				// alert('Error al Guardar');
			}
		},

		async remove () {
			try {

				if (!confirm('Esta seguro que desea eliminar el registro?')) return;
				await this.$_remove();
				alert('Registro eliminado correctamente.');
				this.$router.back();

			} catch (e) {
				alert('Error al eliminar');
			}
		}
	}
};
