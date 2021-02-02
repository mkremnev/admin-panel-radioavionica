import React, { useState } from 'react';
import {
	CContainer,
	CRow,
	CCard,
	CCardHeader,
	CCardBody,
	CForm,
	CFormGroup,
	CLabel,
	CInput,
	CFormText,
	CInputGroupPrepend,
	CInputGroup,
	CInputGroupText,
	CButton,
	CButtonGroup,
	CInputFile,
	CSpinner,
	CToaster,
	CToast,
	CToastHeader,
	CToastBody,
} from '@coreui/react';
import CIcon from '@coreui/icons-react';

import { actions } from './reducer';
import { useDispatch, useSelector } from 'react-redux';
import { StoreState } from '@/store';
import { isEmpty } from 'ramda';

const OfficialState: { [index: string]: string } = { subunit: '', rank: '', fio: '', telephone: '' };
const unitState: { [index: string]: string } = { name: '', address: '', lastname: '', firstname: '', surname: '', amount: '' };

const AddUnit = () => {
	const [officialLists, setOfficialList] = useState<{ [index: string]: string }[]>([OfficialState]);
	const [unitData, setUnitData] = useState<{ [index: string]: string }>(unitState);
	const [uploadFiles, setUploadFiles] = useState<any>(null);
	const dispatch = useDispatch();

	const { requesting, successful, errors } = useSelector((state: StoreState) => state.addunit);

	const handleInputChangeUnit = (e: React.ChangeEvent<HTMLInputElement>) => {
		const { name, value } = e.target;
		const list: { [index: string]: string } = { ...unitData };
		list[name] = value;
		setUnitData(list);
	};

	const handleInputChangeOfficials = (e: React.ChangeEvent<HTMLInputElement>, index: number) => {
		const { name, value } = e.target;
		const list: Array<{ [index: string]: string }> = [...officialLists];
		list[index][name] = value;
		setOfficialList(list);
	};

	const handleRemoveClick = (index: number) => {
		const list = [...officialLists];
		list.splice(index, 1);
		setOfficialList(list);
	};

	const handleAddClick = () => {
		setOfficialList([...officialLists, { subunit: '', rank: '', fio: '', telephone: '' }]);
	};

	const onSubmit = (ev: React.FormEvent) => {
		ev.preventDefault();
		const { requesting } = actions;
		const unit = { ...unitData, officials: [...officialLists] };
		const formData: FormData = new FormData();

		if (uploadFiles !== null) {
			formData.append('procuration', uploadFiles, uploadFiles.name);
		}

		formData.append('json', JSON.stringify(unit));

		dispatch(requesting(formData));
	};

	return (
		<>
			<CToaster position={'top-center'}>
				<CToast show={successful} autohide={3000} fade={true}>
					<CToastHeader closeButton={true}>Успешно.</CToastHeader>
					<CToastBody>Новая воинская часть добавлена.</CToastBody>
				</CToast>
			</CToaster>
			<CCard>
				<CCardHeader>
					<h4>Новая воинская часть</h4>
				</CCardHeader>
				<CCardBody>
					<CRow>
						<CForm className="container-fluid" onSubmit={onSubmit}>
							<CFormGroup>
								<CLabel htmlFor="name">№ воинской части</CLabel>
								<CInputGroup className="lg-5">
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="text"
										id="name"
										name="name"
										placeholder="Воинская часть №..."
										value={unitData.name}
									/>
								</CInputGroup>
								<CFormText className="help-block">Воинская часть в формате: 23345</CFormText>
							</CFormGroup>

							<CFormGroup>
								<CLabel htmlFor="address">Адрес воинской части</CLabel>
								<CInputGroup className="lg-5">
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="text"
										id="address"
										name="address"
										placeholder="Адрес воинской части..."
										value={unitData.address}
									/>
								</CInputGroup>
								<CFormText className="help-block">Адресс воинской части в формате: 00000, Самарская обл., г.Отрадный, ул. Ленина 155</CFormText>
							</CFormGroup>

							<CFormGroup>
								<CLabel>ФИО командира</CLabel>
								<CInputGroup className="lg-5">
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="text"
										id="lastname"
										name="lastname"
										placeholder="Фамилия..."
										value={unitData.lastname}
									/>
									&nbsp;
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="text"
										id="firstname"
										name="firstname"
										placeholder="Имя..."
										value={unitData.firstname}
									/>
									&nbsp;
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="text"
										id="surname"
										name="surname"
										placeholder="Отчество..."
										value={unitData.surname}
									/>
								</CInputGroup>
								<CFormText className="help-block">Фамилия, Имя, Отчество командира</CFormText>
							</CFormGroup>

							<CFormGroup>
								<CLabel htmlFor="address">Количество комплектов</CLabel>
								<CInputGroup className="lg-5">
									<CInputGroupPrepend>
										<CInputGroupText className={'bg-info text-white'}>
											<CIcon name={'cilUser'} />
										</CInputGroupText>
									</CInputGroupPrepend>
									<CInput
										onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeUnit(e)}
										type="number"
										id="amount"
										name="amount"
										placeholder="Количество..."
										value={unitData.amount}
									/>
								</CInputGroup>
								<CFormText className="help-block">Количество комплектов КРУС в эклсплуатации</CFormText>
							</CFormGroup>

							<CFormGroup>
								<CLabel htmlFor="procuration">Доверенность на командира</CLabel>
								<CInputFile onChange={(e: any) => setUploadFiles(e.target.files[0])} id="procuration" name="procuration" />
								<CFormText className="help-block">Отсканированная копия доверенности на командира части</CFormText>
							</CFormGroup>
							{officialLists.map((item, i) => {
								return (
									<>
										<CCard key={i + 'card'}>
											<CCardHeader className="flex-column" key={i + 'header'}>
												<CRow className="justify-content-between" key={i + 'row'}>
													<h5 key={i + 'h5_officials'}>Должностное лицо</h5>
													<div className="btn-box" key={i + 'btn_box'}>
														<CButtonGroup key={i + 'button_gr'}>
															{officialLists.length !== 1 && (
																<CButton color="danger" className="mr10" onClick={() => handleRemoveClick(i)} key={i + 'remove'}>
																	Удалить
																</CButton>
															)}
															&nbsp;
															{officialLists.length - 1 === i && (
																<CButton color="success" onClick={handleAddClick} key={i + 'add'}>
																	Добавить
																</CButton>
															)}
														</CButtonGroup>
													</div>
												</CRow>
											</CCardHeader>
											<CCardBody key={i + 'body'}>
												<CFormGroup key={i + 'form_subunit'}>
													<CLabel htmlFor="subunit" key={i + 'label_subunit'}>
														Подразделение
													</CLabel>
													<CInputGroup className="lg-5" key={i + 'CInputGroup_subunit'}>
														<CInputGroupPrepend key={i + 'CInputGroupPrepend_subunit'}>
															<CInputGroupText className={'bg-info text-white'} key={i + 'CInputGroupText_subunit'}>
																<CIcon name={'cilUser'} key={i + 'CIcon_subunit'} />
															</CInputGroupText>
														</CInputGroupPrepend>
														<CInput
															key={i + 'CInput_subunit'}
															onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeOfficials(e, i)}
															type="text"
															id="subunit"
															name="subunit"
															value={item.subunit}
															placeholder="Подразделение..."
														/>
													</CInputGroup>
													<CFormText className="help-block" key={i + 'CFormText_subunit'}>
														Подразделение
													</CFormText>
												</CFormGroup>

												<CFormGroup key={i + 'CFormGroup_rank'}>
													<CLabel htmlFor="rank" key={i + 'CLabel_rank'}>
														Воинское звание
													</CLabel>
													<CInputGroup className="lg-5" key={i + 'CInputGroup_rank'}>
														<CInputGroupPrepend key={i + 'CInputGroupPrepend_rank'}>
															<CInputGroupText className={'bg-info text-white'} key={i + 'CInputGroupText_rank'}>
																<CIcon name={'cilUser'} key={i + 'CIcon_rank'} />
															</CInputGroupText>
														</CInputGroupPrepend>
														<CInput
															key={i + 'CInput_rank'}
															onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeOfficials(e, i)}
															type="text"
															id="rank"
															name="rank"
															value={item.rank}
															placeholder="Воинское звание..."
														/>
													</CInputGroup>
													<CFormText className="help-block" key={i + 'CFormText_rank'}>
														Воинское звание
													</CFormText>
												</CFormGroup>

												<CFormGroup key={i + 'CFormGroup_fio'}>
													<CLabel htmlFor="fio" key={i + 'CLabel_fio'}>
														Фамилия должностного лица
													</CLabel>
													<CInputGroup className="lg-5" key={i + 'CInputGroup_fio'}>
														<CInputGroupPrepend key={i + 'CInputGroupText_fio'}>
															<CInputGroupText className={'bg-info text-white'} key={i + 'CInputGroupText_fio'}>
																<CIcon name={'cilUser'} key={i + 'CInputGroupText_fio'} />
															</CInputGroupText>
														</CInputGroupPrepend>
														<CInput
															key={i + 'CInput_fio'}
															onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeOfficials(e, i)}
															type="text"
															id="fio"
															name="fio"
															value={item.fio}
															placeholder="Фамилия должностного лица..."
														/>
													</CInputGroup>
													<CFormText className="help-block">Фамилия должностного лица</CFormText>
												</CFormGroup>

												<CFormGroup key={i + 'CFormGroup_telephone'}>
													<CLabel htmlFor="telephone" key={i + 'CLabel_telephone'}>
														Телефон
													</CLabel>
													<CInputGroup className="lg-5" key={i + 'CInputGroup_telephone'}>
														<CInputGroupPrepend key={i + 'CInputGroupPrepend_telephone'}>
															<CInputGroupText className={'bg-info text-white'} key={i + 'CInputGroupText_telephone'}>
																<CIcon name={'cilUser'} key={i + 'CIcon_telephone'} />
															</CInputGroupText>
														</CInputGroupPrepend>
														<CInput
															key={i + 'CInput_telephone'}
															onChange={(e: React.ChangeEvent<HTMLInputElement>) => handleInputChangeOfficials(e, i)}
															type="text"
															id="telephone"
															name="telephone"
															value={item.telephone}
															placeholder="Телефон должностного лица..."
														/>
													</CInputGroup>
													<CFormText className="help-block" key={i + 'CFormText_telephone'}>
														Телефон должностного лица
													</CFormText>
												</CFormGroup>
											</CCardBody>
										</CCard>
									</>
								);
							})}
							<CRow className={'no-gutters'} alignHorizontal={'end'}>
								<CButton color="info" type="submit" disabled={isEmpty(unitData.name)}>
									{requesting ? (
										<>
											Отправка данных...&nbsp;
											<CSpinner color="info" size="sm" />
										</>
									) : (
										<>Добавить</>
									)}
								</CButton>
							</CRow>
						</CForm>
					</CRow>
				</CCardBody>
			</CCard>
		</>
	);
};

export default AddUnit;
