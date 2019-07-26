import Proxy from './Proxy';

class AccountProxy extends Proxy {
	/**
	 * The constructor for the ArtistProxy.
	 *
	 * @param {Object} parameters The query parameters.
	 */
	constructor (parameters = {}) {
		super('cuenta', parameters);
	}
}

export default AccountProxy;
