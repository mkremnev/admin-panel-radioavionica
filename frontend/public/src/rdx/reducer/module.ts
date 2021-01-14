import { IModule } from 'redux-dynamic-modules';

import { reducer } from './reducer';

export const getCommonModule = (): IModule<typeof reducer> => ({
	id: 'common',
	reducerMap: {
		sidebarShow: reducer,
	},
});
