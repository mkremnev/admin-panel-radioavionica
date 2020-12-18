export const getDefects = () => {
	return fetch('http://localhost:5000/db/defects.json').then((res) =>
		res.json(),
	);
};

export const getListsUnits = () => {
	return fetch('http://localhost:5000/db/lists.json').then((res) =>
		res.json(),
	);
};
