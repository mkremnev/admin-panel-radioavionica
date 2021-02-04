import { createSlice, PayloadAction } from '@reduxjs/toolkit';

type initialType = {
	requesting: boolean;
	successful: boolean;
	errors: Array<{
		name: string;
		address: string;
		amount: string;
		lastname: string;
		firstname: string;
		surname: string;
	}>;
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
		errors: (
			state,
			{
				payload,
			}: PayloadAction<{
				name: '';
				address: '';
				amount: '';
				lastname: '';
				firstname: '';
				surname: '';
			}>,
		) => ({
			...state,
			requesting: false,
			errors: [payload],
		}),
		reset: () => ({
			requesting: false,
			successful: false,
			errors: [],
		}),
	},
});

export const { reducer, actions } = addUnitSlice;
