import axios from 'axios';
import { AxiosInstance } from 'axios';

const baseURL = 'http://localhost:8081',
	timeout = 6000;

const ax: AxiosInstance = axios.create({
	baseURL,
	timeout,
	headers: {
		'Content-Type': 'application/json',
		'Accept-Language': 'ru',
	},
});

export { ax as axios };
