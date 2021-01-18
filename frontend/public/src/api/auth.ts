import { axios } from '@/axios';
import { handleApiErrors } from '@/api/api-errors';
import { AxiosResponse } from 'axios';

const sleep = (x: number) => new Promise((r) => setTimeout(r, x));

export const login = async (name: string) => {
	await localStorage.setItem('login', name);
};

export const logout = async () => {
	await localStorage.removeItem('login');
};

export const getUserSession = async () => {
	const login = await localStorage.getItem('login');
	return login;
};

export const isLoggedIn = async () => {
	const login = await getUserSession();
	return Boolean(login);
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
