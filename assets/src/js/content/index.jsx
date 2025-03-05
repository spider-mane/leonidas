import {render} from 'solid-js/web';
import App from '../content/App';

/**
 * @typedef {Object} Config
 */

/**
 * @typedef {Object} Data
 */

/**
 * @param {null|Data|Config} current
 * @param {HTMLElement} node
 * @param {string} entry
 */
const cascade = (entry, current, node) => {
  let resolved, data;

  if (null !== current) {
    resolved = current;
  } else if ((data = node.dataset[entry])) {
    resolved = JSON.parse(data);

    node.removeAttribute(`data-${entry}`);
  }

  return resolved;
};

/**
 * @param {HTMLElement} root
 * @param {Config} config
 * @param {Data} content
 */
export default (root, content = null, config = null, alerts = null) => {
  content = cascade('content', content, root);
  config = cascade('config', config, root);
  alerts = cascade('alerts', alerts, root);

  render(() => <App data={content} config={config} />, root);
};
