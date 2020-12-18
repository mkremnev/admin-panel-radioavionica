import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export type ListsStore = {
	data: [];
	loading: boolean;
	error: boolean;
};

export const initialState: ListsStore = {
	data: [],
	loading: false,
	error: false,
};

export const dataLists = createSlice({
	name: 'lists',
	initialState,
	reducers: {
		requestedLists: (state: ListsStore) => ({
			...state,
			loading: true,
		}),
		requestedListsSuccess: (
			state: ListsStore,
			{ payload }: PayloadAction<[]>,
		) => ({
			...state,
			data: payload,
			loading: false,
		}),
		requestedListsFailure: (state: ListsStore) => ({
			...state,
			error: true,
		}),
	},
});

export const { reducer, actions } = dataLists;
