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
