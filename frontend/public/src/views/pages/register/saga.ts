import { isEmpty } from 'ramda';
import { call, takeLatest, put } from 'redux-saga/effects';

import { actions } from './reducer';
import { register } from '@/api/auth';

function signupApi(email: string, password: string) {
	return register(email, password);
}

function* signupFlow({ payload }: ReturnType<typeof actions.requesting>) {
	try {
		const { email, password } = payload;
		const response = yield call(signupApi, String(email), String(password));
		yield put(actions.successful(response));
	} catch (error) {
		yield put(actions.errors(!isEmpty(error) ? error : 'Not error'));
	}
}

export function* signupWatcher() {
	yield takeLatest(actions.requesting.type, signupFlow);
}
