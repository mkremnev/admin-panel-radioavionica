export const getDefects = () => {
	return fetch('http://localhost:8081/v1/defects/all').then((res) =>
		res.json(),
	);
};

export const getListsUnits = () => {
	return fetch('http://localhost:8081/v1/units/all').then((res) =>
		res.json(),
	);
};
