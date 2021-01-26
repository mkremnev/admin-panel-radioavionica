import { ISagaModule } from 'redux-dynamic-modules-saga';

import { reducer } from './reducer';
import { watchRequestedLists } from './saga';

export const getUnitsModule = (): ISagaModule<typeof reducer> => ({
	id: 'units_list',
	reducerMap: {
		listsUnits: reducer,
	},
	sagas: [watchRequestedLists],
});
