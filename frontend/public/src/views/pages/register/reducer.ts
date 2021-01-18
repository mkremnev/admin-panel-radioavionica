import { createSlice, PayloadAction } from '@reduxjs/toolkit';
import { StoreState } from '@/store';

export const initialState: {
	requesting?: boolean;
	successful?: boolean;
	messages?: object[];
	errors?: object[];
} = {
	requesting: false,
	successful: false,
	messages: [],
	errors: [],
};

export const selectors = {
	state: ({ requestProps }: StoreState) => requestProps,
};

export const registerSlice = createSlice({
	name: 'user',
	initialState,
	reducers: {
		requesting: (
			state,
			{ payload }: PayloadAction<{ email: string; password: string }>,
		) => ({
			...state,
			requesting: true,
			messages: [{ body: 'Signing up...', time: new Date() }],
		}),
		successful: (state, { payload }: PayloadAction<{ email: string }>) => ({
			...state,
			requesting: false,
			successful: true,
			messages: [
				{
					body: `Successfully created account for ${payload.email}`,
					time: new Date(),
				},
			],
		}),
		errors: (state, { payload }: PayloadAction<object[]>) => ({
			...state,
			errors: [payload],
		}),
	},
});

export const { reducer, actions } = registerSlice;
