import React from 'react';
import { Route, Redirect } from 'react-router-dom';

//TODO поменять тип у props
export const PrivateRoute = ({ component: Component, ...rest }: any) => (
	<Route
		{...rest}
		render={(props) =>
			localStorage.getItem('user')
				? <Component {...props} />
				: <Redirect to={{ pathname: '/login', state: { from: props.location } }} />
	}
	/>
);
