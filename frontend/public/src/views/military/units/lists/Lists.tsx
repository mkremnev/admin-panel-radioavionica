import React, { useEffect, useState } from 'react';
import { CRow, CDataTable, CButton, CCollapse, CCardBody } from '@coreui/react';
import { connect } from 'react-redux';
import { actions } from './reducer';
import { StoreState } from '@/store';

function mapStateToProps(state: StoreState) {
	return {
		loading: state.listsUnits.loading,
		error: state.listsUnits.error,
		data: state.listsUnits.data,
	};
}
const mapDispatchToProps = {
	request: actions.requestedLists,
	response: actions.requestedListsSuccess,
	failure: actions.requestedListsFailure,
};
type TheListProps = ReturnType<typeof mapStateToProps> & typeof mapDispatchToProps;

type DataType = {
	id: number;
	name: string;
	address: string;
	fio_commander: string;
	amount: number;
	file_lists_complects: string;
	procuration: string;
	officials: Array<{}>;
};

const TheListsComponent: React.FC<TheListProps> = (props) => {
	const [details, setDetails] = useState<number[]>([]);
	useEffect(() => {
		props.request();
	}, [props.request]);

	const fields = [
		{ key: 'id', label: '#', _style: { width: '3%' }, filter: false },
		{ key: 'name', label: 'Наименование части', _style: { width: '4%' } },
		{
			key: 'address',
			label: 'Адрес',
			_style: { width: '6%' },
			filter: false,
		},
		{
			key: 'fio_commander',
			label: 'ФИО командира',
			_style: { width: '4%' },
		},
		{
			key: 'procuration',
			label: 'Доверенность на командира',
			_style: { width: '5%' },
			filter: false,
		},
		{
			key: 'amount',
			label: 'Количество КРУС',
			_style: { width: '4%' },
			filter: false,
		},
		{
			key: 'file_lists_complects',
			label: 'База комплектов',
			_style: { width: '4%' },
			filter: false,
		},
		{
			key: 'notes',
			label: 'Примечание',
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

	const officialsField = [
		{
			key: 'official_subunit',
			label: 'Подразделение',
			_style: { width: '10%' },
			filter: false,
		},
		{
			key: 'official_rank',
			label: 'В.звание',
			_style: { width: '10%' },
			filter: false,
		},
		{
			key: 'official_fio',
			label: 'ФИО должносного лица',
			_style: { width: '10%' },
			filter: false,
		},
		{
			key: 'official_telephone',
			label: 'Телефон',
			_style: { width: '10%' },
			filter: false,
		},
	];

	const toggleDetails = (index: number) => {
		const position: number = details.indexOf(index);
		let newDetails: number[] = details.slice();
		if (position !== -1) {
			newDetails.splice(position, 1);
		} else {
			newDetails = [...details, index];
		}
		setDetails(newDetails);
	};

	const officialsData = props.data.map((el: DataType) => {
		return el.officials;
	});

	return (
		<div className="card">
			<div className="card-header d-flex justify-content-between align-items-center">
				<h4>Список воинских частей</h4>
				<CButton color="success" className="m-2" to="/modules/create-units">
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
							// eslint-disable-next-line @typescript-eslint/camelcase,react/display-name
							fio_commander: (item: { commander_firstname: string; commander_lastname: string; commander_surname: string }) => {
								return <td key={item.commander_firstname}>{item.commander_lastname + ' ' + item.commander_firstname + ' ' + item.commander_surname}</td>;
							},
							// eslint-disable-next-line react/display-name
							showDetails: (item: DataType, index: number) => {
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
											{details.includes(index) ? 'Закрыть' : 'Открыть'}
										</CButton>
									</td>
								);
							},
							// eslint-disable-next-line react/display-name
							details: (items: DataType, index: number) => {
								return (
									<CCollapse show={details.includes(index)}>
										<CCardBody>
											<h5>Должностные лица</h5>
											<CDataTable items={officialsData[index]} fields={officialsField} />
										</CCardBody>
									</CCollapse>
								);
							},
						}}
					/>
				</CRow>
			</div>
		</div>
	);
};

const TheLists = connect(mapStateToProps, mapDispatchToProps)(TheListsComponent);

export default React.memo(TheLists);
