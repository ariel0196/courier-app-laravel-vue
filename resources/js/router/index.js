import routes from './routes';

const config = {
	mode: 'hash', // Demo is living in GitHub.io, so required!
	linkActiveClass: 'open active',
	scrollBehavior: () => ({
		y: 0
	}),
	routes
};

export default config;
