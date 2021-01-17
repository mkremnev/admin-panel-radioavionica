import { AxiosResponse } from 'axios';

export function handleApiErrors(response: AxiosResponse) {
	if (response.status > 202) throw Error('Error');
	return response;
}
