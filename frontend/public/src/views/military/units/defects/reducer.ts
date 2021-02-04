import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export type DefectsStore = {
	data: [];
	loading: boolean;
	error: boolean;
};

export const initialState: DefectsStore = {
	data: [],
	loading: false,
	error: false,
};

export const dataDefects = createSlice({
	name: 'defects',
	initialState,
	reducers: {
		requestedDefects: (state: DefectsStore) => ({
			...state,
			loading: true,
		}),
		requestedDefectsSuccess: (state: DefectsStore, { payload }: PayloadAction<{ data: [] }>) => ({
			...state,
			data: payload.data,
			loading: false,
		}),
		requestedDefectsFailure: (state: DefectsStore) => ({
			...state,
			error: true,
		}),
	},
});

export const { reducer, actions } = dataDefects;
