import React, { useEffect, useState } from 'react';
import { CRow, CDataTable, CButton, CCollapse } from '@coreui/react';
import { connect } from 'react-redux';
import { actions } from './reducer';
import { StoreState } from '@/store';
import { DynamicModuleLoader } from 'redux-dynamic-modules';
import { getDefectsModule } from '@/views/military/units/defects/module';
import { element } from 'prop-types';

function mapStateToProps(state: StoreState) {
	return {
		loading: state.defects.loading,
		error: state.defects.error,
		data: state.defects.data,
	};
}
const mapDispatchToProps = {
	request: actions.requestedDefects,
	response: actions.requestedDefectsSuccess,
	failure: actions.requestedDefectsFailure,
};
type TheDefectsProps = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

const TheDefectsComponent: React.FC<TheDefectsProps> = ({ request, data }) => {
	const [details, setDetails] = useState<number[]>([]);
	useEffect(() => {
		request();
	}, [request]);

	const fields = [
		{ key: 'id', label: '№ п/п', _style: { width: '3%' }, filter: false },
		{ key: 'unit', label: 'в/ч', _style: { width: '4%' } },
		{
			key: 'responsible',
			label: 'Ответсвенные',
			_style: { width: '6%' },
			filter: false,
		},
		{ key: 'district', label: 'Округ', _style: { width: '4%' } },
		{
			key: 'amount',
			label: 'Количество КРУС',
			_style: { width: '4%' },
			filter: false,
		},
		{
			key: 'delivery_year',
			label: 'Год поставки',
			_style: { width: '4%' },
		},
		{
			key: 'commissioning_date',
			label: 'Дата ввода в эксплуатацию',
			_style: { width: '5%' },
			filter: false,
		},
		{
			key: 'warranty',
			label: 'Гарантийные',
			_style: { width: '3%' },
			filter: false,
		},
		{
			key: 'non_warranty',
			label: 'Негарантийные',
			_style: { width: '3%' },
			filter: false,
		},
		{
			key: 'defects',
			label: 'Неисправности',
			_style: { width: '4%' },
			filter: false,
		},
		{
			key: 'notes',
			label: 'Примечание',
			_style: { width: '40%' },
			filter: false,
		},
		{
			key: 'components',
			label: 'Компоненты',
			_style: { width: '10%' },
			filter: false,
		},
		{
			key: 'showDetails',
			label: '',
			_style: { width: '1%' },
			sorter: false,
			filter: false,
		},
	];

	const componentsName: {
		[keys: string]: string;
	} = {
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_ak1: 'АК1',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_pkk: 'ПКК',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kpe1: 'КПЭ1',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kab004: 'Кабель004',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kab136: 'Кабель136',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kab137: 'Кабель137',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_zu: 'ЗУ',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_zupkk: 'ЗУПКК',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_mfp: 'МФП',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_pou: 'ПОУ',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_mirs: 'МИРС',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_msns: 'МСНС',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kab152: 'Кабель152',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_kab153: 'Кабель153',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_tmg36: 'ТМГ36',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_gvsh: 'ГВШ',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_pdu: 'ПДУ4',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_r168: 'Р168',
		// eslint-disable-next-line @typescript-eslint/camelcase
		components_r438: 'Р438',
	};

	const toggleDetails = (index: number) => {
		const position: number = details.indexOf(index);
		let newDetails: number[] = details.slice();
		if (position !== -1) {
			newDetails.splice(position, 1);
		} else {
			newDetails = [...details, index];
		}
		setDetails(newDetails as []);
	};

	return (
		<DynamicModuleLoader modules={[getDefectsModule()]}>
			<div className="card">
				<div className="card-header d-flex justify-content-between align-items-center">
					<h4>Список неисправностей по частям</h4>
					<CButton
						color="success"
						className="m-2"
						to="/modules/create-defects"
					>
						Добавить
					</CButton>
				</div>
				<div className="card-body">
					<CRow>
						<CDataTable
							items={data}
							fields={fields}
							columnFilter
							hover
							scopedSlots={{
								// eslint-disable-next-line react/display-name
								defects: (item: {
									fault_component: number;
									fault_mik: number;
								}) => {
									return (
										<td>
											Периферия: {item.fault_component}
											<br />
											МИК: {item.fault_mik}
										</td>
									);
								},
								// eslint-disable-next-line react/display-name
								notes: (
									items: {
										notes: {
											[key: string]: string;
										};
									},
									index: number,
								) => {
									return (
										<td>
											<div
												className={
													!details.includes(index)
														? 'visible'
														: 'hide'
												}
											>
												{items.notes[0]['note_notice']}
											</div>
											<CCollapse
												show={details.includes(index)}
											>
												{Object.keys(items.notes).map(
													(
														keys: number,
														i: number,
													) => (
														<span key={i}>
															{
																items.notes[
																	keys
																]['note_notice']
															}
															<br />
														</span>
													),
												)}
											</CCollapse>
										</td>
									);
								},
								// eslint-disable-next-line react/display-name
								showDetails: (item: any, index: number) => {
									return (
										<td className="py-2">
											<CButton
												color="primary"
												variant="outline"
												shape="square"
												size="sm"
												onClick={() => {
													toggleDetails(index);
												}}
											>
												{details.includes(index)
													? 'Закрыть'
													: 'Открыть'}
											</CButton>
										</td>
									);
								},
								// eslint-disable-next-line react/display-name
								components: (
									items: {
										[key: string]: string;
									},
									index: number,
								) => {
									return (
										<td>
											<CCollapse
												show={details.includes(index)}
											>
												{Object.keys(items)
													.filter((el) => {
														if (
															/components_/.test(
																el,
															)
														) {
															return el;
														}
													})
													.map((keys, i) => (
														<span key={i}>
															{`${componentsName[keys]}: ${items[keys]}`}
															<br />
														</span>
													))}
											</CCollapse>
										</td>
									);
								},
							}}
						/>
					</CRow>
				</div>
			</div>
		</DynamicModuleLoader>
	);
};

const TheDefects = connect(
	mapStateToProps,
	mapDispatchToProps,
)(TheDefectsComponent);
export default React.memo(TheDefects);
