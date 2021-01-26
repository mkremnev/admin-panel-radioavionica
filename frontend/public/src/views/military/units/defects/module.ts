import { ISagaModule } from 'redux-dynamic-modules-saga';

import { reducer } from './reducer';
import { watchRequestedDefects } from './saga';

export const getDefectsModule = (): ISagaModule<typeof reducer> => ({
	id: 'defects',
	reducerMap: {
		defects: reducer,
	},
	sagas: [watchRequestedDefects],
});
