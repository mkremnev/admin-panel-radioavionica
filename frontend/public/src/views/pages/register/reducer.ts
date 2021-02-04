import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export const initialState: {
	requesting?: boolean;
	successful?: boolean;
	errors?: Array<{ email?: string; password?: string }>;
} = {
	requesting: false,
	successful: false,
	errors: [],
};

export const registerSlice = createSlice({
	name: 'user',
	initialState,
	reducers: {
		requesting: (state, { payload }: PayloadAction<{ email: string; password: string }>) => ({
			...state,
			requesting: true,
		}),
		successful: (state, { payload }: PayloadAction<{ email: string }>) => ({
			...state,
			requesting: false,
			successful: true,
			errors: [],
		}),
		errors: (state, { payload }: PayloadAction<{}>) => ({
			...state,
			requesting: false,
			errors: [payload],
		}),
	},
});

export const { reducer, actions } = registerSlice;
