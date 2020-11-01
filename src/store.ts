import { configureStore, getDefaultMiddleware } from '@reduxjs/toolkit';
import { combineReducers } from 'redux';
import { CommonReducer } from '@/rdx/reducer';

export const reducer = combineReducers({
	sidebarShow: CommonReducer.reducer,
});

const store = configureStore({
	reducer,
});

export type StoreState = ReturnType<typeof reducer>;
export default store;
