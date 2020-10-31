import React, { useEffect, useState, createRef } from 'react';
import classNames from 'classnames';
import { CRow, CCol } from '@coreui/react';

const AcceptanceDocuments: React.FC<{}> = () => {
	return (
		<div className="card">
			<div className="card-header">Документы для военной приемки</div>
			<div className="card-body">
				<CRow></CRow>
			</div>
		</div>
	);
};

export default AcceptanceDocuments;
