import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export const initialState: {
	email?: string;
	password?: string;
	requesting?: boolean;
	successful?: boolean;
	messages?: object[];
	errors?: object[];
} = {
	email: '',
	password: '',
	requesting: false,
	successful: false,
	messages: [],
	errors: [],
};

export const registerSlice = createSlice({
	name: 'user',
	initialState,
	reducers: {
		requesting: (
			state,
			{ payload }: PayloadAction<{ email: string; password: string }>,
		) => {
			return {
				email: payload.email ?? '',
				password: payload.password ?? '',
				requesting: true,
				successful: false,
				errors: [],
				messages: [{ body: 'Signing up...', time: new Date() }],
			};
		},
		successful: (state, { payload }: PayloadAction<{ email: string }>) => {
			return {
				requesting: false,
				successful: true,
				errors: [],
				messages: [
					{
						body: `Successfully created account for ${payload.email}`,
						time: new Date(),
					},
				],
			};
		},
		errors: (state, { payload }: PayloadAction<{ error: object[] }>) => {
			return {
				errors: payload.error.concat([
					{
						body: payload.error.toString(),
						time: new Date(),
					},
				]),
				messages: [],
				requesting: false,
				successful: false,
			};
		},
	},
});

export const { reducer, actions } = registerSlice;
