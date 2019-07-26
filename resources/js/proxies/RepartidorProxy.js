import Proxy from './Proxy';

class Repartidor extends Proxy {
	constructor (parameters = {}) {
		super('repartidores', parameters);
	}
}

export default Repartidor;
