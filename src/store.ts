import { configureStore, getDefaultMiddleware } from '@reduxjs/toolkit';
import { combineReducers } from 'redux';
import { CommonReducer } from '@/rdx/reducer';
import createSagaMiddleware from 'redux-saga';
import { fork } from 'redux-saga/effects';
import { watchRequestedDefects } from '@/views/military_units/defects/saga';
import { dataDefects } from '@/views/military_units/defects/reducer';

export const reducer = combineReducers({
	sidebarShow: CommonReducer.reducer,
	defects: dataDefects.reducer,
});

const SagaMiddleware = createSagaMiddleware();

function* rootSaga() {
	yield fork(watchRequestedDefects);
}

const store = configureStore({
	reducer,
	middleware: [SagaMiddleware],
});

SagaMiddleware.run(rootSaga);

export type StoreState = ReturnType<typeof reducer>;
export default store;
