import {createContext, useContext} from 'solid-js';

/**
 * @typedef {{
 *  'input-root': string,
 * }} Configuration
 */

export const ConfigContext = createContext();

/**
 * @returns {Configuration}
 */
export const useConfigContext = () => useContext(ConfigContext);

export const ConfigContextProvider = props => {
  const config = props.config ?? {};

  return (
    <ConfigContext.Provider value={config}>
      {props.children}
    </ConfigContext.Provider>
  );
};
