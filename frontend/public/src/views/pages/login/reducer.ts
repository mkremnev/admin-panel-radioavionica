import { createSlice, PayloadAction } from '@reduxjs/toolkit';

type User = {
	id: string;
	email: string;
	role: string;
	status: string;
	date: {
		date: string;
		timezone_type: number;
		timezone: string;
	};
};

export const initialState: {
	requesting?: boolean;
	successful?: boolean;
	errors?: Array<{ email?: string; password?: string }>;
	user?: User;
} = {
	requesting: false,
	successful: false,
	errors: [],
};

export const loginSlice = createSlice({
	name: 'login',
	initialState,
	reducers: {
		requesting: (
			state,
			{
				payload,
			}: PayloadAction<{
				email: string;
				password: string;
			}>,
		) => ({
			...state,
			requesting: true,
		}),
		successful: (state, { payload }: PayloadAction<User>) => ({
			...state,
			requesting: false,
			successful: true,
			errors: [],
			user: payload,
		}),
		errors: (state, { payload }: PayloadAction<{}>) => ({
			...state,
			requesting: false,
			errors: [payload],
		}),
		//TODO перенести в общий редьюсер
		check: (state, { payload }: PayloadAction<{}>) => {
			if (payload) {
				return { ...state, successful: true };
			}
		},
	},
});

export const { reducer, actions } = loginSlice;
