import axios from 'axios';
import { AxiosInstance } from 'axios';

const baseURL = 'http://localhost:8081',
	timeout = 6000;

const tzoffset = new Date().getTimezoneOffset();

const ax: AxiosInstance = axios.create({
	baseURL,
	timeout,
	headers: {
		'Access-Control-Allow-Origin': '*',
		'Access-Control-Allow-Headers': '*',
		'Access-Control-Allow-Methods': '*',
		'Content-Type': 'application/json',
		'Local-Timezone-offset': -tzoffset,
		'Accept-Language': 'ru',
	},
});

export { ax as axios };
