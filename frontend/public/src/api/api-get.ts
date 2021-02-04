import { AxiosResponse } from 'axios';
import { handleApiErrors } from '@/api/api-errors';
import { axios } from '@/axios';

export const apiGet = () => {
	return axios
		.get('http://localhost:8081/v1/defects/all')
		.then((response: AxiosResponse) => handleApiErrors(response))
		.then((data) => data);
};

export const getListsUnits = () => {
	return axios.get('http://localhost:8081/v1/units/all').then((response: AxiosResponse) => handleApiErrors(response));
};
