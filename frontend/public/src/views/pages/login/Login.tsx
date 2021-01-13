import React from 'react';
import { Link } from 'react-router-dom';
import {
	CButton,
	CCard,
	CCardBody,
	CCardGroup,
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

const Login = () => {
	return (
		<div className="c-app c-default-layout flex-row align-items-center">
			<CContainer>
				<CRow className="justify-content-center">
					<CCol md="8">
						<CCardGroup>
							<CCard className="p-4">
								<CCardBody>
									<CForm>
										<h1>Аутентификация.</h1>
										<p className="text-muted">
											Введите информацию от вашего
											аккаунта
										</p>
										<CInputGroup className="mb-3">
											<CInputGroupPrepend>
												<CInputGroupText>
													<CIcon name="cil-user" />
												</CInputGroupText>
											</CInputGroupPrepend>
											<CInput
												type="text"
												placeholder="Имя"
												autoComplete="username"
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
												placeholder="Пароль"
												autoComplete="current-password"
											/>
										</CInputGroup>
										<CRow>
											<CCol xs="6">
												<CButton
													color="primary"
													className="px-4"
												>
													Войти
												</CButton>
											</CCol>
											<CCol xs="6" className="text-right">
												<CButton
													color="link"
													className="px-0"
												>
													Забыли свой пароль?
												</CButton>
											</CCol>
										</CRow>
									</CForm>
								</CCardBody>
							</CCard>
							<CCard
								className="text-white bg-primary py-5 d-md-down-none"
								style={{ width: '44%' }}
							>
								<CCardBody className="text-center">
									<div>
										<h2>Зарегистрироваться</h2>
										<p>Личный кабинет пользователя.</p>
										<Link to="/register">
											<CButton
												color="primary"
												className="mt-3"
												active
												tabIndex={-1}
											>
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
