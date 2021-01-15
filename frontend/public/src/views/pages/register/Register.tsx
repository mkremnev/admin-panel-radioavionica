import React, { FC, useCallback, useState } from 'react';
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

import { StoreState } from '@/store';
import { actions } from './reducer';
import { connect } from 'react-redux';
import { isEmpty } from 'ramda';

const mapStateToProps = ({ register }: StoreState) => ({
	...register,
});

const mapDispatchToProps = {
	register: actions.register,
};

export type Props = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

const Register: FC<Props> = ({ email, password, register }) => {
	const [useremail, setEmail] = useState(email);
	const [userpassword, setPassword] = useState(password);
	const onSubmit = useCallback(
		async (ev) => {
			ev.preventDefault();
			console.log('onsubmit');
			if (!isEmpty(useremail) && !isEmpty(userpassword)) {
				console.log('test');
				register({ email: useremail, password: userpassword });
			}
		},
		[useremail, userpassword, register],
	);
	return (
		<div className="c-app c-default-layout flex-row align-items-center">
			<CContainer>
				<CRow className="justify-content-center">
					<CCol md="9" lg="7" xl="6">
						<CCard className="mx-4">
							<CCardBody className="p-4">
								<CForm onSubmit={onSubmit}>
									<h1>Register</h1>
									<p className="text-muted">
										Create your account
									</p>
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
											onChange={(ev) =>
												setEmail(
													(ev.target as HTMLInputElement)
														.value,
												)
											}
											value={useremail}
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
											onChange={(ev) =>
												setPassword(
													(ev.target as HTMLInputElement)
														.value,
												)
											}
											value={userpassword}
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
										onClick={onSubmit}
										block
									>
										Create Account
									</CButton>
								</CForm>
							</CCardBody>
							<CCardFooter className="p-4">
								<CRow>
									<CCol xs="12" sm="6">
										<CButton
											className="btn-facebook mb-1"
											block
										>
											<span>facebook</span>
										</CButton>
									</CCol>
									<CCol xs="12" sm="6">
										<CButton
											className="btn-twitter mb-1"
											block
										>
											<span>twitter</span>
										</CButton>
									</CCol>
								</CRow>
							</CCardFooter>
						</CCard>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default connect(mapStateToProps, mapDispatchToProps)(Register);
