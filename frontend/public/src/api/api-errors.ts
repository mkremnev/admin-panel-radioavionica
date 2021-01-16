import { AxiosResponse } from 'axios';

export function handleApiErrors(response: AxiosResponse) {
	if (response.status > 201) throw Error(response.statusText);
	return response;
}
