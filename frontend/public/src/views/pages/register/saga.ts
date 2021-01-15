import { isEmpty } from 'ramda';
import { take, call } from 'redux-saga/effects';

import { actions } from './reducer';
import { register, logout } from '@/api/auth';

export function* clearUserSession() {
	yield call(logout);
}

export function* saveUserSession({
	payload,
}: ReturnType<typeof actions.register>) {
	const email = String(payload.email);
	const password = String(payload.password);
	if (!isEmpty(email) && !isEmpty(password)) {
		yield call(register, email, password);
	}
}

export function* registerSaga() {
	while (true) {
		const action = yield take(actions.register.type);
		yield* saveUserSession(action);
		yield take(actions.logout.type);
		yield* clearUserSession();
	}
}
