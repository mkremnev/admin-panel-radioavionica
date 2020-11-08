import React, { useEffect, useState, createRef } from 'react';
import classNames from 'classnames';
import { CRow, CCol } from '@coreui/react';

const TripDocument: React.FC<{}> = () => {
	return (
		<div className="card">
			<div className="card-header">
				Отчетные документы по командировке
			</div>
			<div className="card-body">
				<CRow></CRow>
			</div>
		</div>
	);
};

export default TripDocument;
