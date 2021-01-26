import { ISagaModule } from 'redux-dynamic-modules-saga';

import { reducer } from './reducer';
import { signWatcher } from './saga';

export const getLoginModule = (): ISagaModule<typeof reducer> => ({
	id: 'login',
	reducerMap: {
		login: reducer,
	},
	sagas: [signWatcher],
});
