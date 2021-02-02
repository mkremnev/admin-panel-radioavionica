import { createSlice, PayloadAction } from '@reduxjs/toolkit';

type initialType = {
	requesting: boolean;
	successful: boolean;
	errors: Array<{}>;
};

const initialState: initialType = {
	requesting: false,
	successful: false,
	errors: [],
};

export const addUnitSlice = createSlice({
	name: 'add_unit',
	initialState,
	reducers: {
		requesting: (state, { payload }: PayloadAction<FormData>) => ({
			...state,
			requesting: true,
		}),
		successful: (state, { payload }: PayloadAction) => ({
			...state,
			requesting: false,
			successful: true,
		}),
		errors: (state, { payload }: PayloadAction<{}>) => ({
			...state,
			requesting: false,
			errors: [payload],
		}),
	},
});

export const { reducer, actions } = addUnitSlice;
