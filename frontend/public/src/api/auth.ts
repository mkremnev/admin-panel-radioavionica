import { axios } from '@/axios';

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
	return axios
		.post(
			`/v1/auth/join`,
			JSON.stringify({ email: email, password: password }),
		)
		.then((response) => response)
		.catch((error) => error.response.data);
};
