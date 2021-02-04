import React, { ReactNode, FC } from 'react';
import { useSelector } from 'react-redux';
import { Redirect } from 'react-router-dom';
import { Spinner } from '@/components/Spinner/Spinner';

import { StoreState } from '@/store';

type Props = {
	children: ReactNode;
	redirectPath?: string;
};

export const AccessChecker: FC<Props> = ({ children, redirectPath = '/login' }) => {
	const { successful } = useSelector((state: StoreState) => state.login);

	if (!successful) {
		return <Redirect to={redirectPath} />;
	}

	return <>{children}</>;
};
