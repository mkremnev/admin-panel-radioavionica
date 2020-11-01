import React, { useEffect, useState, createRef } from 'react';
import classNames from 'classnames';
import { CRow, CCol } from '@coreui/react';

const Lists: React.FC<{}> = () => {
	return (
		<div className="card">
			<div className="card-header">Список воинских частей</div>
			<div className="card-body">
				<CRow></CRow>
			</div>
		</div>
	);
};

export default Lists;
