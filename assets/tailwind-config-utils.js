const {theme} = require('tailwindcss/stubs/defaultConfig.stub');

/**
 * @param {number} index
 * @param {Array} array
 */
function maybeSplit(index, array) {
  return index + 1 < array.length ? '-' : '';
}

/**
 * @param {string} features
 */
function use(...features) {
  let bundle = '';

  features.forEach((feature, i) => {
    bundle +=
      `(${Object.keys(theme[feature]).join('|')})` + maybeSplit(i, features);
  });

  return bundle;
}

/**
 * @param {string} blocks
 */
function match(...blocks) {
  let pattern = '';

  blocks.forEach((block, i) => {
    pattern += block + maybeSplit(i, blocks);
  });

  return new RegExp(pattern);
}

module.exports = {use, match};
