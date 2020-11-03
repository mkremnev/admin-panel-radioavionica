import { actions } from './reducer';
import { call, put, takeEvery } from 'redux-saga/effects';
import { getDefects } from '@/api/getDefects';

function* fetchDefectsAsync() {
	try {
		const data = yield call(getDefects);
		yield put(actions.requestedDefectsSuccess(data));
	} catch (error) {
		yield put(actions.requestedDefectsFailure());
	}
}

export function* watchRequestedDefects() {
	yield takeEvery(actions.requestedDefects.type, fetchDefectsAsync);
}
