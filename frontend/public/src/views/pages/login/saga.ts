import { isEmpty } from 'ramda';
import { call, takeLatest, put, fork } from 'redux-saga/effects';
import {} from 'react-router-dom';

import { actions } from './reducer';
import { login, getUserSession, logout } from '@/api/api-auth';

function signApi(email: string, password: string) {
	return login(email, password);
}

function* signFlow({ payload }: ReturnType<typeof actions.requesting>) {
	try {
		const { email, password } = payload;
		const response = yield call(signApi, String(email), String(password));
		localStorage.setItem('user', JSON.stringify(response.data.id));
		yield put(actions.successful(response.data));
	} catch (error) {
		yield put(actions.errors(!isEmpty(error.response.data['errors'] || !isEmpty(error.response.data['message'])) ? error.response.data['errors'] || error.response.data['message'] : 'Not error'));
	}
}
export function* clearUserSession() {
	yield call(logout);
}

export function* checkUserSession() {
	const userSession: string = yield call(getUserSession);
	if (userSession?.length > 3 && !isEmpty(userSession)) {
		yield put(actions.check(userSession));
	} else {
		yield* clearUserSession();
	}
}

export function* signWatcher() {
	yield fork(checkUserSession);
	yield takeLatest(actions.requesting.type, signFlow);
}
