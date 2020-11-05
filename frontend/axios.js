import axios from 'axios';

const baseURL = 'http://localhost:8888',
	timeout = 6000;

const tzoffset = new Date().getTimezoneOffset();

const ax = axios.create({
	baseURL,
	timeout,
	hedders: {
		'Content-Type': 'application/json',
		'Local-Timezone-offset': -tzoffset
	}
});

export { ax as axios };
