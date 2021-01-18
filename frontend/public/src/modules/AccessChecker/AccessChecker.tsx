import React, { ReactNode, FC } from 'react';
import { connect } from 'react-redux';
import { Redirect } from 'react-router-dom';
import { Spinner } from '@/components/Spinner/Spinner';

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
		return <Spinner />;
	}

	if (status === CheckState.failed) {
		return <Redirect to={redirectPath} />;
	}

	return <>{children}</>;
};

export const AccessChecker = connect(mapStateToProps)(AccessCheckerComponent);
