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

const mapStateToProps = ({ requestProps }: StoreState) => ({
	...requestProps,
});

const mapDispatchToProps = {
	requesting: actions.requesting,
};

export type Props = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

const Register: FC<Props> = ({
	email,
	password,
	messages,
	errors,
	requesting,
}) => {
	const [useremail, setEmail] = useState(email);
	const [userpassword, setPassword] = useState(password);
	const onSubmit = useCallback(
		async (ev) => {
			console.log('click');
			ev.preventDefault();
			if (!isEmpty(useremail) && !isEmpty(userpassword)) {
				requesting({ email: useremail, password: userpassword });
			}
		},
		[messages, errors],
	);
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
										onClick={requesting}
										block
									>
										Зарегистрировать
									</CButton>
								</CForm>
							</CCardBody>
						</CCard>
					</CCol>
				</CRow>
			</CContainer>
		</div>
	);
};

export default connect(mapStateToProps, mapDispatchToProps)(Register);
