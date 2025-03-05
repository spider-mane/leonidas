import {createContext, useContext} from 'solid-js';
import {useConfigContext} from './ConfigContext';
import {listToInput, listToSlug} from '../functions';

/**
 * @typedef {Array<string|number>} DataPath
 * @typedef {(path: DataPath) => string} DataPathFormatter
 */

export const ActionContext = createContext();

/**
 * @returns {{
 *   qualifyPath: (path: DataPath) => DataPath
 *   maybeFormatPath: (path: DataPath|string, format: DataPathFormatter) => string
 *   pathInput: (path: DataPath|string) => string
 *   pathSlug: (path: DataPath|string) => string
 * }}
 */
export const useActionContext = () => useContext(ActionContext);

export const ActionContextProvider = props => {
  const config = useConfigContext();
  const inputRoot = config['input-root'];

  /**
   * @param {DataPath} path
   *
   * @returns {DataPath}
   */
  const qualifyPath = path => [inputRoot, ...path];

  /**
   * @param {DataPath|string} path
   * @param {DataPathFormatter} format
   */
  const maybeFormatPath = (path, format) =>
    typeof path === 'string' ? path : format(qualifyPath(path));

  /**
   * @param {DataPath|string} path
   */
  const pathInput = path => maybeFormatPath(path, listToInput);

  /**
   * @param {DataPath|string} path
   */
  const pathSlug = path => maybeFormatPath(path, listToSlug);

  const actions = {
    prefixPath: qualifyPath,
    maybeFormatPath,
    pathInput,
    pathSlug,
  };

  return (
    <ActionContext.Provider value={actions}>
      {props.children}
    </ActionContext.Provider>
  );
};
