import React, { FC } from 'react';
import { Route, Switch } from 'react-router-dom';
import './scss/style.scss';

const loading = (
	<div className="pt-3 text-center">
		<div className="sk-spinner sk-spinner-pulse"></div>
	</div>
);

// Containers
const TheLayout = React.lazy(() => import('./containers/TheLayout'));

// Pages
const Login = React.lazy(() => import('./views/pages/login/Login'));
const Register = React.lazy(() => import('./views/pages/register/Register'));
const Page404 = React.lazy(() => import('./views/pages/page404/Page404'));
const Page500 = React.lazy(() => import('./views/pages/page500/Page500'));

export const AppContainer: FC<{}> = () => {
	return (
		<React.Suspense fallback={loading}>
			<Switch>
				<Route exact path="/login" render={(props) => <Login {...props} />} />
				<Route exact path="/register" render={(props) => <Register {...props} />} />
				<Route exact path="/404" render={(props) => <Page404 {...props} />} />
				<Route exact path="/500" render={(props) => <Page500 {...props} />} />

				<Route path="/" render={(props) => <TheLayout {...props} />} />
			</Switch>
		</React.Suspense>
	);
};
