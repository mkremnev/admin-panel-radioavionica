import { actions } from './reducer';
import { call, put, takeEvery } from 'redux-saga/effects';
import { getListsUnits } from '@/api/getDefects';

function* fetchDefectsAsync() {
	try {
		const data = yield call(getListsUnits);
		yield put(actions.requestedListsSuccess(data));
	} catch (error) {
		yield put(actions.requestedListsFailure());
	}
}

export function* watchRequestedLists() {
	yield takeEvery(actions.requestedLists.type, fetchDefectsAsync);
}
