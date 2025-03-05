import {createContext, useContext} from 'solid-js';
import {useDataContext} from './DataContext';
import {pushFormSubmission} from '../functions';

/**
 * @typedef {Array<string|number>} DataPath
 * @typedef {(path: DataPath) => string} DataPathFormatter
 */

export const InputActionsContext = createContext();

/**
 * @returns {{
 *  mirrorInput: (path: DataPath, event: InputEvent) => void
 *  maybeSubmitForm: (input: HTMLElement) => void
 * }}
 */
export const useInputActionsContext = () => useContext(InputActionsContext);

export const InputActionsContextProvider = props => {
  const {setData} = useDataContext();

  /**
   * @param {Array<string|int>} path
   * @param {InputEvent} event
   *
   * @returns {void}
   */
  const mirrorInput = (path, event) => setData(...path, event.target.value);

  /**
   * @param {HTMLElement} input
   */
  const maybeSubmitForm = input => {
    let form = input.form;

    if (form) {
      pushFormSubmission(form, input);
    }
  };

  const actions = {mirrorInput, maybeSubmitForm};

  return (
    <InputActionsContext.Provider value={actions}>
      {props.children}
    </InputActionsContext.Provider>
  );
};
