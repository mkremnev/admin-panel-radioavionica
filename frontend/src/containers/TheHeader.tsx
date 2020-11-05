import React from 'react';
import {
	CHeader,
	CToggler,
	CHeaderBrand,
	CHeaderNav,
	CHeaderNavItem,
	CHeaderNavLink,
	CSubheader,
	CBreadcrumbRouter,
} from '@coreui/react';
import CIcon from '@coreui/icons-react';
import { connect } from 'react-redux';
import { actions } from '@/rdx/reducer';
import { StoreState } from '@/store';

// routes config
import routes from '../routes';

import {
	TheHeaderDropdown,
	TheHeaderDropdownMssg,
	TheHeaderDropdownNotif,
	TheHeaderDropdownTasks,
} from './index';

function mapStateToProps(state: StoreState) {
	return {
		sidebarShow: state.sidebarShow.sidebarShow,
	};
}
const mapDispatchToProps = {
	SidebarShow: actions.set,
};
type TheHeaderProps = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

const TheHeaderComponent: React.FC<TheHeaderProps> = (
	props: TheHeaderProps,
) => {
	const show = props.sidebarShow;

	const toggleSidebar = () => {
		const val = [true, 'responsive'].includes(show) ? false : 'responsive';
		props.SidebarShow(val);
	};

	const toggleSidebarMobile = () => {
		const val = [false, 'responsive'].includes(show) ? true : 'responsive';
		props.SidebarShow(val);
	};

	return (
		<CHeader withSubheader>
			<CToggler
				inHeader
				className="ml-md-3 d-lg-none"
				onClick={toggleSidebarMobile}
			/>
			<CToggler
				inHeader
				className="ml-3 d-md-down-none"
				onClick={toggleSidebar}
			/>
			<CHeaderBrand className="mx-auto d-lg-none" to="/">
				<CIcon name="logo" height="48" alt="Logo" />
			</CHeaderBrand>

			<CHeaderNav className="d-md-down-none mr-auto">
				<CHeaderNavItem className="px-3">
					<CHeaderNavLink to="/users">Сотрудники</CHeaderNavLink>
				</CHeaderNavItem>
				<CHeaderNavItem className="px-3">
					<CHeaderNavLink>Настройки</CHeaderNavLink>
				</CHeaderNavItem>
			</CHeaderNav>

			<CHeaderNav className="px-3">
				<TheHeaderDropdownNotif />
				<TheHeaderDropdownTasks />
				<TheHeaderDropdownMssg />
				<TheHeaderDropdown />
			</CHeaderNav>

			<CSubheader className="px-3 justify-content-between">
				<CBreadcrumbRouter
					className="border-0 c-subheader-nav m-0 px-0 px-md-3"
					routes={routes}
				/>

				{/*//TODO Здесь будет статус пользователя: командировка | офис |
				отпуск | больничный */}
			</CSubheader>
		</CHeader>
	);
};

const TheHeader = connect(
	mapStateToProps,
	mapDispatchToProps,
)(TheHeaderComponent);
export default TheHeader;
