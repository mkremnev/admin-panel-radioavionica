import React from 'react';
import Loader from 'react-loader-spinner';
import styled from '@emotion/styled';

const WrapperSpinner = styled.div`
	display: flex;
	display: flex;
	flex-wrap: wrap;
	flex-direction: row;
	justify-content: center;
	align-items: center;
	width: 100%;
	height: 100vh;
`;

export const Spinner = () => {
	return (
		<WrapperSpinner>
			<Loader type="Circles" color="#00BFFF" height={80} width={80} />
		</WrapperSpinner>
	);
};
