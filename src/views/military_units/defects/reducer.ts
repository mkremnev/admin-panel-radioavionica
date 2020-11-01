import { createSlice, PayloadAction } from '@reduxjs/toolkit';

export const initialState = {};

export const dataDefects = createSlice({
	name: 'defects',
	initialState,
	reducers: {},
});

export const { reducer, actions } = dataDefects;
