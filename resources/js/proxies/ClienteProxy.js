import Proxy from './Proxy';

class ClienteProxy extends Proxy {
	constructor (parameters = {}) {
		super('clientes', parameters);
	}

	envios (id) {
		return this.submit('get', `${this.endpoint}/${id}/envios`);
	}
}

export default ClienteProxy;
