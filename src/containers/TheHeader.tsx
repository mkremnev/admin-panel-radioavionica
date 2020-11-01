import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import {
	CHeader,
	CToggler,
	CHeaderBrand,
	CHeaderNav,
	CHeaderNavItem,
	CHeaderNavLink,
	CSubheader,
	CBreadcrumbRouter,
	CLink,
} from '@coreui/react';
import CIcon from '@coreui/icons-react';

// routes config
import routes from '../routes';

import {
	TheHeaderDropdown,
	TheHeaderDropdownMssg,
	TheHeaderDropdownNotif,
	TheHeaderDropdownTasks,
} from './index';

type StateHeader = {
	sidebarShow?: boolean | undefined | string;
};

const TheHeader: React.FC<StateHeader> = () => {
	const dispatch = useDispatch();
	const sidebarShow = useSelector((state: StateHeader) => state.sidebarShow);

	const toggleSidebar = () => {
		const val = [true, 'responsive'].includes(
			sidebarShow as boolean | string,
		)
			? false
			: 'responsive';
		dispatch({ type: 'set', sidebarShow: val });
	};

	const toggleSidebarMobile = () => {
		const val = [false, 'responsive'].includes(
			sidebarShow as boolean | string,
		)
			? true
			: 'responsive';
		dispatch({ type: 'set', sidebarShow: val });
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

export default TheHeader;
