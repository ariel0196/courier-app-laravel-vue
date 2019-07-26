import CrudMixin from './CrudMixin';

export default {

	mixins: [ CrudMixin ],

	mounted () { this.$refs.modal.$on('hide', () => this.reset()); },

	methods: {

		$_emitRemove () { this.$emit('remove'); },

		$_emitSave () { this.$emit('save'); },

		cancel () { this.$refs.modal.hide(); },

		async show (id) {
			try {

				await this.$_fetch(id);
				this.$validator.reset();
				this.$refs.modal.show();

			} catch (e) {
				alert('Error al obtener el registro.');
			}
		},

		async save () {
			try {

				if(!await this.$_save()) return;
				this.$_emitSave();
				if (confirm('Registro guardado correctamente. Volver atras?'))
					this.$refs.modal.hide();

			} catch (e) {
				alert(e.response.data ? e.response.data.error : 'Error en la peticion.');
				// alert('Error al Guardar');
			}
		},

		async remove () {
			try {

				if (!confirm('Esta seguro que desea eliminar el registro?')) return;
				await this.$_remove();
				this.$_emitRemove();
				alert('Registro eliminado correctamente.');
				this.$refs.modal.hide();

			} catch (e) {
				return alert('Error al eliminar');
			}

		}
	}
};
