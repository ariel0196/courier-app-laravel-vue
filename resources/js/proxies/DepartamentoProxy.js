import Proxy from './Proxy';

class DepartamentoProxy extends Proxy {
	constructor (parameters = {}) {
		super('departamentos', parameters);
	}
}

export default DepartamentoProxy;
