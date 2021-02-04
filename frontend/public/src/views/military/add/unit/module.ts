import { ISagaModule } from 'redux-dynamic-modules-saga';

import { reducer } from './reducer';
import { watchRequestedAddUnit } from './saga';

export const addUnitModule = (): ISagaModule<typeof reducer> => ({
	id: 'adding_unit',
	reducerMap: {
		addunit: reducer,
	},
	sagas: [watchRequestedAddUnit],
});
