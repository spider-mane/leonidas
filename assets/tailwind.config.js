const {use, match} = require('./tailwind-config-utils');

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['../views/**/*.twig', '../src/Library/Admin/**/*.php'],
  plugins: [],
  theme: {
    extend: {},
  },
  safelist: [{pattern: match('(p|py|px|pt|pb|pr|pl)', use('spacing'))}],
};
