import { actions } from './reducer';
import { call, put, takeEvery } from 'redux-saga/effects';
import { apiGet } from '@/api/api-get';

function* fetchDefectsAsync() {
	try {
		const data = yield call(apiGet);
		yield put(actions.requestedDefectsSuccess(data));
	} catch (error) {
		yield put(actions.requestedDefectsFailure());
	}
}

export function* watchRequestedDefects() {
	yield takeEvery(actions.requestedDefects.type, fetchDefectsAsync);
}
