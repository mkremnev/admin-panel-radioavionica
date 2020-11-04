import { createSlice, PayloadAction } from '@reduxjs/toolkit';

type State = {
	sidebarShow: '' | true | false | 'responsive';
};

export const initialState: State = {
	sidebarShow: 'responsive',
};

export const CommonReducer = createSlice({
	name: 'common',
	initialState,
	reducers: {
		set: (state, { payload }: PayloadAction<State>) => {
			return {
				...state,
				sidebarShow: payload,
			};
		},
	},
});

export const { reducer, actions } = CommonReducer;
