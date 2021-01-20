import { axios } from '@/axios';
import { handleApiErrors } from '@/api/api-errors';
import { AxiosResponse } from 'axios';

const sleep = (x: number) => new Promise((r) => setTimeout(r, x));

export const login = async (email: string, password: string) => {
	await sleep(1000);
	return axios
		.post(`/v1/login`, JSON.stringify({ email: email, password: password }))
		.then((response: AxiosResponse) => handleApiErrors(response));
};

export const logout = async () => {
	await localStorage.removeItem('user');
};

export const getUserSession = async () => {
	const login = await localStorage.getItem('user');
	return login;
};

export const register = async (email: string, password: string) => {
	await sleep(1000);
	return axios
		.post(
			`/v1/auth/join`,
			JSON.stringify({ email: email, password: password }),
		)
		.then((response: AxiosResponse) => handleApiErrors(response));
};
