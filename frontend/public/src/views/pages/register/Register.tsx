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

import { store, StoreState } from '@/store';
import { actions } from './reducer';
import { connect, useSelector } from 'react-redux';
import { isEmpty } from 'ramda';

const mapStateToProps = ({ requestProps }: StoreState) => ({
	...requestProps,
});

const mapDispatchToProps = {
	request: actions.requesting,
};

export type Props = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

export const Register: FC<Props> = ({
	request,
	requesting,
	messages,
	successful,
	errors,
}) => {
	const [email, setEmail] = useState('');
	const [password, setPassword] = useState('');

	const onSubmit = (ev: React.FormEvent) => {
		ev.preventDefault();
		if (!isEmpty(email) && !isEmpty(password)) {
			request({ email: email, password: password });
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
									{<div>{errors && <div>test</div>}</div>}
								</div>
							</CCardFooter>
						</CCard>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default connect(mapStateToProps, mapDispatchToProps)(Register);
