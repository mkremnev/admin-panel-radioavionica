import { combineReducers } from 'redux';
import { CommonReducer } from '@/rdx/reducer';
import { dataDefects } from '@/views/military/units/defects/reducer';
import { dataLists } from '@/views/military/units/lists/reducer';
import { loginSlice } from '@/views/pages/login/reducer';
import { createStore } from 'redux-dynamic-modules';
import { getSagaExtension } from 'redux-dynamic-modules-saga';
import { getLoginModule } from '@/views/pages/login/module';
import { registerSlice } from '@/views/pages/register/reducer';
import { getRegisterModule } from '@/views/pages/register/module';
import { getDefectsModule } from '@/views/military/units/defects/module';
import { getUnitsModule } from '@/views/military/units/lists/module';

export const reducer = combineReducers({
	sidebarShow: CommonReducer.reducer,
	defects: dataDefects.reducer,
	listsUnits: dataLists.reducer,
	login: loginSlice.reducer,
	register: registerSlice.reducer,
});

export type StoreState = ReturnType<typeof reducer>;

export const store = createStore<StoreState>(
	{ extensions: [getSagaExtension({})] },
	getLoginModule(),
	getRegisterModule(),
	getDefectsModule(),
	getUnitsModule(),
);
