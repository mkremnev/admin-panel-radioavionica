import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export enum StatusState {
	initiated,
	succeed,
	failed,
}

export const initialState: {
	email: string;
	password: string;
	status?: StatusState;
} = {
	email: '',
	password: '',
	status: StatusState.initiated,
};

export const registerSlice = createSlice({
	name: 'user',
	initialState,
	reducers: {
		register: (
			state,
			{ payload }: PayloadAction<{ email: string; password: string }>,
		) => {
			if (payload) {
				return { email: payload.email, password: payload.password };
			}
			return state;
		},
		logout: () => ({
			email: '',
			password: '',
			status: StatusState.failed,
		}),
	},
});

export const { reducer, actions } = registerSlice;
