module.exports = {
  root: true,
  parser: '@typescript-eslint/parser',
  parserOptions: {
    tsConfigRoot: __dirname,
    project: ['./tsconfig.json'],
    sourceType: 'module',
    ecmaFeatures: {
      sourceType: 'module',
      globalReturn: true,
      jsx: true,
    },
  },
  extends: [
    'eslint:recommended',
    'plugin:@typescript-eslint/recommended',
    'plugin:@typescript-eslint/recommended-requiring-type-checking',
    'plugin:jsdoc/recommended',
    'plugin:jsx-a11y/recommended',
    'plugin:react/recommended',
    'plugin:react-hooks/recommended',
    'prettier',
  ],
  plugins: ['@typescript-eslint', 'jsdoc', 'jsx-a11y', 'react', 'react-hooks'],
  globals: {
    wp: true,
  },
  env: {
    es2022: true,
    browser: true,
    commonjs: true,
    amd: true,
    jquery: true,
  },
  settings: {
    'jsx-a11y': {
      components: {},
    },
    react: {
      version: 'detect',
    },
  },
  rules: {},
};
