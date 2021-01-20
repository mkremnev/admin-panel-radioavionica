import React from 'react';
import { DynamicModuleLoader } from 'redux-dynamic-modules';
import { TheContent, TheSidebar, TheFooter, TheHeader } from './index';
import { AccessChecker } from '@/modules/AccessChecker/AccessChecker';
import { ErrorBoundary } from '@/components/ErrorBoundary/ErrorBoundary';
import { getCommonModule } from '@/rdx/reducer/module';
import { getLoginModule } from '@/views/pages/login/module';

const TheLayout = () => {
	return (
		<ErrorBoundary>
			<DynamicModuleLoader
				modules={[getCommonModule(), getLoginModule()]}
			>
				<AccessChecker>
					<div className="c-app c-default-layout">
						<TheSidebar />
						<div className="c-wrapper">
							<TheHeader />
							<div className="c-body">
								<TheContent />
							</div>
							<TheFooter />
						</div>
					</div>
				</AccessChecker>
			</DynamicModuleLoader>
		</ErrorBoundary>
	);
};

export default TheLayout;
