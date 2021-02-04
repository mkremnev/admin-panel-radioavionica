import { isEmpty } from 'ramda';
import { call, takeLatest, put } from 'redux-saga/effects';

import { actions } from './reducer';
import { addUnit } from '@/api/api-post';

function addUnitApi(data: any) {
	return addUnit(data);
}

function* addUnitFlow({ payload }: ReturnType<typeof actions.requesting>) {
	try {
		const response = yield call(addUnitApi, payload);
		yield put(actions.successful(response));
	} catch (error) {
		yield put(actions.errors(!isEmpty(error.response.data['errors'] || !isEmpty(error.response.data['message'])) ? error.response.data['errors'] || error.response.data['message'] : 'Not error'));
	}
}

export function* watchRequestedAddUnit() {
	yield takeLatest(actions.requesting.type, addUnitFlow);
}
