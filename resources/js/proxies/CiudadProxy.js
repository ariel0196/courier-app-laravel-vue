import Proxy from './Proxy';

class CiudadProxy extends Proxy {
	constructor (parameters = {}) {
		super('ciudades', parameters);
	}
}

export default CiudadProxy;
