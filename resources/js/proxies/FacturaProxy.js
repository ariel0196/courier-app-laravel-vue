import Proxy from './Proxy';

class FacturaProxy extends Proxy {

	constructor (parameters = {}) {
		super('facturas', parameters);
	}

	chart() {
		return this.submit('get', `${this.endpoint}/chart`);
	}
}

export default FacturaProxy;
