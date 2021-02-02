import { axios } from '@/axios';
import { handleApiErrors } from '@/api/api-errors';
import { AxiosResponse } from 'axios';
import { sleep } from '@/api/api-helpers';

export const addUnit = async (data: FormData) => {
	await sleep(1000);
	return axios.post(`/v1/add/unit`, data).then((response: AxiosResponse) => handleApiErrors(response));
};
