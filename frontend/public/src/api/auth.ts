import { axios } from '@/axios';
import { AxiosResponse } from 'axios';
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
	return (
		axios
			.post(
				`/v1/auth/join/`,
				JSON.stringify({ email: email, password: password }),
			)
			// eslint-disable-next-line @typescript-eslint/no-use-before-define
			.then((response) => handleResponse(response))
	);
};

function handleResponse(response: AxiosResponse) {
	if (!response.status) {
		if (response.status === 401) {
			// auto logout if 401 response returned from api
			logout();
			location.reload(true);
		}

		const error =
			(response.data && response.data.message) || response.statusText;
		return Promise.reject(error);
	}

	return response.data;
}
