module.exports = {
	clearMocks: true,
	coverageDirectory: 'coverage',
	transform: {
		'^.+\\.(js|jsx|ts|tsx)$': '<rootDir>/node_modules/babel-jest',
	},
	moduleNameMapper: {
		'\\.(css|less)$': '<rootDir>/settings/__mocks__/styleMock.js',
		'^@/(.*)$': '<rootDir>/src/$1',
	},
	cacheDirectory: 'tmp/test',
	moduleDirectories: ['node_modules', 'src'],
	testEnvironment: 'jsdom',
	setupFilesAfterEnv: ['<rootDir>/settings/jestSettings.js'],
};
