import React, { FC, useEffect, useState } from 'react';
import {
	CButton,
	CCard,
	CCardBody,
	CCardFooter,
	CCol,
	CContainer,
	CForm,
	CInput,
	CInputGroup,
	CInputGroupPrepend,
	CInputGroupText,
	CRow,
} from '@coreui/react';
import CIcon from '@coreui/icons-react';

import { actions } from './reducer';
import { useDispatch, useSelector } from 'react-redux';
import { isEmpty } from 'ramda';
import { StoreState } from '@/store';

export const Register = () => {
	const [email, setEmail] = useState('');
	const [password, setPassword] = useState('');
	const dispatch = useDispatch();
	const { requesting, messages, successful, errors } = useSelector(
		(state: StoreState) => state.register,
	);

	const onSubmit = (ev: React.FormEvent) => {
		ev.preventDefault();
		const { requesting } = actions;
		if (!isEmpty(email) && !isEmpty(password)) {
			dispatch(requesting({ email: email, password: password }));
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
										<CInput
											type="text"
											placeholder="Username"
											autoComplete="username"
										/>
									</CInputGroup>
									<CInputGroup className="mb-3">
										<CInputGroupPrepend>
											<CInputGroupText>@</CInputGroupText>
										</CInputGroupPrepend>
										<CInput
											type="text"
											placeholder="Email"
											autoComplete="email"
											name="email"
											value={email}
											onChange={(ev) =>
												setEmail(
													(ev.target as HTMLInputElement)
														.value,
												)
											}
										/>
									</CInputGroup>
									<CInputGroup className="mb-3">
										<CInputGroupPrepend>
											<CInputGroupText>
												<CIcon name="cil-lock-locked" />
											</CInputGroupText>
										</CInputGroupPrepend>
										<CInput
											type="password"
											placeholder="Password"
											autoComplete="new-password"
											name="password"
											value={password}
											onChange={(ev) =>
												setPassword(
													(ev.target as HTMLInputElement)
														.value,
												)
											}
										/>
									</CInputGroup>
									<CInputGroup className="mb-4">
										<CInputGroupPrepend>
											<CInputGroupText>
												<CIcon name="cil-lock-locked" />
											</CInputGroupText>
										</CInputGroupPrepend>
										<CInput
											type="password"
											placeholder="Repeat password"
											autoComplete="new-password"
										/>
									</CInputGroup>
									<CButton
										color="success"
										type="submit"
										block
									>
										Зарегистрировать
									</CButton>
								</CForm>
							</CCardBody>
							<CCardFooter>
								<div className="auth-messages">
									{
										<div>
											{errors!.length > 0 && (
												<div>test</div>
											)}
										</div>
									}
								</div>
							</CCardFooter>
						</CCard>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default Register;
