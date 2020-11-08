import React, { useEffect, useState, createRef } from 'react';
import classNames from 'classnames';
import { CRow, CCol } from '@coreui/react';

const CreateDefects: React.FC<{}> = () => {
	return (
		<div className="card">
			<div className="card-header">Новый дефект</div>
			<div className="card-body">
				<CRow></CRow>
			</div>
		</div>
	);
};

export default CreateDefects;
