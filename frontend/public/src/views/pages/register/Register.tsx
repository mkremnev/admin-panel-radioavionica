import React, { useState } from 'react';
import { CAlert, CButton, CCard, CCardBody, CCardFooter, CCol, CContainer, CForm, CInput, CInputGroup, CInputGroupPrepend, CInputGroupText, CRow, CSpinner } from '@coreui/react';
import CIcon from '@coreui/icons-react';
import { Link } from 'react-router-dom';

import { actions } from './reducer';
import { useDispatch, useSelector } from 'react-redux';
import { StoreState } from '@/store';
import { isEmptyData } from '@/helpers/helpers';

const Register = () => {
	//TODO реализовать валидацию полей ввода и провести оптимизацию
	const [email, setEmail] = useState('');
	const [password, setPassword] = useState('');
	const dispatch = useDispatch();
	const { requesting, successful, errors } = useSelector((state: StoreState) => state.register);

	const onSubmit = (ev: React.FormEvent) => {
		ev.preventDefault();
		const { requesting } = actions;
		if (!isEmptyData(email, password)) {
			dispatch(requesting({ email: email, password: password }));
			setEmail('');
			setPassword('');
		}
	};

	return (
		<div className="c-app c-default-layout flex-row align-items-center">
			<CContainer>
				<CRow className="justify-content-center">
					<CCol md="9" lg="7" xl="6">
						<CCard className="mx-4">
							<CCardBody className="p-4">
								<CForm onSubmit={onSubmit}>
									<h1>Регистрация нового пользователя</h1>
									<CInputGroup className="mb-3">
										<CInputGroupPrepend>
											<CInputGroupText>
												<CIcon name="cil-user" />
											</CInputGroupText>
										</CInputGroupPrepend>
										<CInput type="text" placeholder="Username" autoComplete="username" />
									</CInputGroup>
									{errors!.length > 0 && errors![0].email && <CAlert color="danger">{JSON.stringify(errors![0].email)}</CAlert>}
									<CInputGroup className="mb-3">
										<CInputGroupPrepend>
											<CInputGroupText>@</CInputGroupText>
										</CInputGroupPrepend>
										<CInput
											type="text"
											placeholder="Email"
											autoComplete="email"
											required
											name="email"
											value={email}
											onChange={(ev) => setEmail((ev.target as HTMLInputElement).value)}
										/>
									</CInputGroup>
									{errors!.length > 0 && errors![0].password && <CAlert color="danger">{JSON.stringify(errors![0].password)}</CAlert>}
									<CInputGroup className="mb-3">
										<CInputGroupPrepend>
											<CInputGroupText>
												<CIcon name="cil-lock-locked" />
											</CInputGroupText>
										</CInputGroupPrepend>
										<CInput
											type="password"
											placeholder="Password"
											autoComplete="password"
											required
											min={10}
											name="password"
											value={password}
											onChange={(ev) => setPassword((ev.target as HTMLInputElement).value)}
										/>
									</CInputGroup>
									<CInputGroup className="mb-4">
										<CInputGroupPrepend>
											<CInputGroupText>
												<CIcon name="cil-lock-locked" />
											</CInputGroupText>
										</CInputGroupPrepend>
										<CInput type="password" placeholder="Repeat password" autoComplete="new-password" />
									</CInputGroup>
									<CButton color="success" type="submit" disabled={isEmptyData(email, password)} block>
										{requesting ? (
											<>
												Отправка данных...&nbsp;
												<CSpinner color="info" size="sm" />
											</>
										) : (
											<>Зарегистрировать</>
										)}
									</CButton>
								</CForm>
							</CCardBody>
							<CCardFooter>
								<CAlert show={successful} color="success" fade closeButton>
									Регистрация прошла успешна! Спасибо за регистацию. <Link to="/login">Залогиниться</Link>
								</CAlert>
							</CCardFooter>
						</CCard>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default Register;
