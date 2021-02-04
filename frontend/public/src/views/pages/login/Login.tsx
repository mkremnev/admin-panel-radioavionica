import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { CButton, CCard, CCardBody, CCardGroup, CCol, CContainer, CForm, CInput, CInputGroup, CInputGroupPrepend, CInputGroupText, CRow, CSpinner } from '@coreui/react';
import CIcon from '@coreui/icons-react';

import { actions } from './reducer';
import { useDispatch, useSelector } from 'react-redux';
import { StoreState } from '@/store';
import { isEmptyData } from '@/helpers/helpers';
import { useHistory, Redirect } from 'react-router';

const Login = () => {
	const [email, setEmail] = useState('');
	const [password, setPassword] = useState('');
	const dispatch = useDispatch();
	const history = useHistory();
	const { requesting, successful, errors, user } = useSelector((state: StoreState) => state.login);

	useEffect(() => {
		if (successful) {
			history.push('/');
		}
	}, [successful]);

	const onSubmit = (ev: React.FormEvent) => {
		ev.preventDefault();
		const { requesting } = actions;
		if (!isEmptyData(email, password)) {
			dispatch(
				requesting({
					email: email,
					password: password,
				}),
			);
			setEmail('');
			setPassword('');
		}
	};
	return successful ? (
		<Redirect to="/" />
	) : (
		<div className="c-app c-default-layout flex-row align-items-center">
			<CContainer>
				<CRow className="justify-content-center">
					<CCol md="8">
						<CCardGroup>
							<CCard className="p-4">
								<CCardBody>
									<CForm onSubmit={onSubmit}>
										<h1>Авторизация.</h1>
										<p className="text-muted">Введите данные для входа в ваш аккаунт.</p>
										<CInputGroup className="mb-3">
											<CInputGroupPrepend>
												<CInputGroupText>
													<CIcon name="cil-user" />
												</CInputGroupText>
											</CInputGroupPrepend>
											<CInput type="text" placeholder="Email" autoComplete="email" value={email} onChange={(ev) => setEmail((ev.target as HTMLInputElement).value)} />
										</CInputGroup>
										<CInputGroup className="mb-4">
											<CInputGroupPrepend>
												<CInputGroupText>
													<CIcon name="cil-lock-locked" />
												</CInputGroupText>
											</CInputGroupPrepend>
											<CInput
												type="password"
												placeholder="Пароль"
												autoComplete="password"
												required
												min={10}
												name="password"
												value={password}
												onChange={(ev) => setPassword((ev.target as HTMLInputElement).value)}
											/>
										</CInputGroup>
										<CRow>
											<CCol xs="6">
												<CButton color="primary" className="px-4" type="submit" disabled={isEmptyData(email, password)}>
													<>
														Войти
														{requesting && (
															<>
																{' '}
																<CSpinner color="info" size="sm" />
															</>
														)}
													</>
												</CButton>
											</CCol>
											<CCol xs="6" className="text-right">
												<CButton color="link" className="px-0">
													Забыли свой пароль?
												</CButton>
											</CCol>
										</CRow>
									</CForm>
								</CCardBody>
							</CCard>
							<CCard className="text-white bg-primary py-5 d-md-down-none" style={{ width: '44%' }}>
								<CCardBody className="text-center">
									<div>
										<h2>Зарегистрироваться</h2>
										<p>Личный кабинет пользователя.</p>
										<Link to="/register">
											<CButton color="primary" className="mt-3" active tabIndex={-1}>
												Зарегистрироваться!
											</CButton>
										</Link>
									</div>
								</CCardBody>
							</CCard>
						</CCardGroup>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default Login;
