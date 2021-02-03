import { createSlice, PayloadAction } from '@reduxjs/toolkit';

type State = {
	sidebarShow: boolean | 'responsive';
};

export const initialState: State = {
	sidebarShow: 'responsive',
};

export const CommonReducer = createSlice({
	name: 'common',
	initialState,
	reducers: {
		set: (state, { payload }: PayloadAction<'responsive' | boolean>) => ({
			...state,
			sidebarShow: payload,
		}),
	},
});

export const { reducer, actions } = CommonReducer;
