import React, { useEffect, useState, createRef, useCallback } from 'react';
import classNames from 'classnames';
import { CRow, CCol, CDataTable, CButton, CCollapse } from '@coreui/react';
import { connect } from 'react-redux';
import { actions } from './reducer';
import { StoreState } from '@/store';

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

const TheDefectsComponent: React.FC<TheDefectsProps> = (props) => {
	const [details, setDetails] = useState<number[]>([]);
	useEffect(() => {
		props.request();
	}, [props.request]);

	const fields = [
		{ key: 'id', label: '№ п/п', _style: { width: '3%' }, filter: false },
		{ key: 'units', label: 'в/ч', _style: { width: '4%' } },
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
			key: 'number_of_warranty',
			label: 'Гарантийные',
			_style: { width: '3%' },
			filter: false,
		},
		{
			key: 'number_of_non_warranty',
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
		ak1: 'АК1',
		pkk: 'ПКК',
		kpe1: 'КПЭ1',
		kab004: 'Кабель004',
		kab136: 'Кабель136',
		kab137: 'Кабель137',
		zu: 'ЗУ',
		zupkk: 'ЗУПКК',
		mfp: 'МФП',
		pou: 'ПОУ',
		mirs: 'МИРС',
		msns: 'МСНС',
		kab152: 'Кабель152',
		kab153: 'Кабель153',
		tmg36: 'ТМГ36',
		gvsh: 'ГВШ',
		pdu: 'ПДУ4',
		r168: 'Р168',
		r438: 'Р438',
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
						items={props.data}
						fields={fields}
						columnFilter
						hover
						scopedSlots={{
							// eslint-disable-next-line react/display-name
							defects: (item: {
								defects: { periphery: number; mik: number };
							}) => {
								return (
									<td>
										Периферия: {item.defects.periphery}
										<br />
										МИК: {item.defects.mik}
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
											{items.notes['item1']}
										</div>
										<CCollapse
											show={details.includes(index)}
										>
											{Object.keys(items.notes).map(
												(keys, i) => (
													<span key={i}>
														{items.notes[keys]}
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
									components: {
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
											{`АК1: ${items.components['ak1']}`}
										</div>
										<CCollapse
											show={details.includes(index)}
										>
											{Object.keys(items.components).map(
												(keys, i) => (
													<span key={i}>
														{`${componentsName[keys]}: ${items.components[keys]}`}
														<br />
													</span>
												),
											)}
										</CCollapse>
									</td>
								);
							},
						}}
					/>
				</CRow>
			</div>
		</div>
	);
};

const TheDefects = connect(
	mapStateToProps,
	mapDispatchToProps,
)(TheDefectsComponent);
export default React.memo(TheDefects);
