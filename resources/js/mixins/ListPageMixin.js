export default {

	data () {
		return {
			table: {
				currentPage: 1,
				totalRows: 0,
				perPage: 10
			},
			filtros: {}
		};
	},

	methods: {

		showCrudModal (row) {
			this.$refs.crudModal.show(row ? row.item.id : null);
		},

		refreshTable () {
			this.$refs.table.refresh();
		},

		async tableItemsProvider (ctx) {
			this.$options.proxy.setParameters({
				...this.filtros,
				'per_page': ctx.perPage,
				'page': ctx.currentPage,
				'sort_by': ctx.sortBy,
				'sort_desc': ctx.sortDesc
			});
			try {
				let {data, meta} = await this.$options.proxy.all();
				this.table.totalRows = meta.total;
				// console.log(data);
				// console.log(this.filtros);
				return data || [];
			} catch (e) {
				// this.isBusy = false;
				return [];
			}
		}
	},

	watch: {
		filtros: {
			handler () {
				this.$refs.table.refresh();
			},
			deep: true
		}
	},
};
