import React from 'react';
import {
	CCreateElement,
	CSidebar,
	CSidebarBrand,
	CSidebarNav,
	CSidebarNavDivider,
	CSidebarNavTitle,
	CSidebarMinimizer,
	CSidebarNavDropdown,
	CSidebarNavItem,
} from '@coreui/react';

import CIcon from '@coreui/icons-react';

// sidebar nav config
import navigation from './_nav';
import { connect } from 'react-redux';
import { actions } from '@/rdx/reducer';
import { StoreState } from '@/store';

function mapStateToProps(state: StoreState) {
	return {
		sidebarShow: state.sidebarShow.sidebarShow,
	};
}
const mapDispatchToProps = {
	SidebarShow: actions.set,
};
type TheSidebarProps = ReturnType<typeof mapStateToProps> &
	typeof mapDispatchToProps;

const TheSidebarComponent: React.FC<TheSidebarProps> = (
	props: TheSidebarProps,
) => {
	const show = props.sidebarShow;

	return (
		<CSidebar
			show={show}
			onShowChange={(val: TheSidebarProps) => props.SidebarShow(val)}
		>
			<CSidebarBrand className="d-md-down-none" to="/">
				<CIcon
					className="c-sidebar-brand-full"
					name="radioavion"
					height={35}
				/>
			</CSidebarBrand>
			<CSidebarNav>
				<CCreateElement
					items={navigation}
					components={{
						CSidebarNavDivider,
						CSidebarNavDropdown,
						CSidebarNavItem,
						CSidebarNavTitle,
					}}
				/>
			</CSidebarNav>
			<CSidebarMinimizer className="c-d-md-down-none" />
		</CSidebar>
	);
};

const TheSidebar = connect(
	mapStateToProps,
	mapDispatchToProps,
)(TheSidebarComponent);
export default React.memo(TheSidebar);
