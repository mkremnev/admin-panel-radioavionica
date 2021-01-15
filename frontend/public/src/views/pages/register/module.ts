import { ISagaModule } from 'redux-dynamic-modules-saga';

import { reducer } from './reducer';
import { registerSaga } from './saga';

export const getRegisterModule = (): ISagaModule<typeof reducer> => ({
	id: 'register',
	reducerMap: {
		register: reducer,
	},
	sagas: [registerSaga],
});
