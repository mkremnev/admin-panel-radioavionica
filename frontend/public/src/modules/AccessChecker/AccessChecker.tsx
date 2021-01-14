import React, { ReactNode, FC } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';
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

import { StoreState } from '@/store';
import { CheckState } from '@/views/pages/login/reducer';

const mapStateToProps = ({ login }: StoreState) => ({
	...login,
});

export interface Props extends ReturnType<typeof mapStateToProps> {
	children: ReactNode;
	redirectPath?: string;
}

export const AccessCheckerComponent: FC<Props> = ({
	children,
	status,
	redirectPath = '/login',
}) => {
	if (status === CheckState.initiated) {
		return (
			<WrapperSpinner>
				<Loader type="Circles" color="#00BFFF" height={80} width={80} />
			</WrapperSpinner>
		);
	}

	if (status === CheckState.failed) {
		return <Redirect to={redirectPath} />;
	}

	return <>{children}</>;
};

export const AccessChecker = connect(mapStateToProps)(AccessCheckerComponent);
