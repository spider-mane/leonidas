import {createContext, useContext} from 'solid-js';
import {createStore} from 'solid-js/store';

export const EditorContext = createContext();

export const useEditorContext = () => useContext(EditorContext);

export const EditorContextProvider = props => {
  let [editor, setEditor] = createStore({
    root: null,
    base: null,
    focus: new Map(),
  });

  return (
    <EditorContext.Provider value={{editor, setEditor}}>
      {props.children}
    </EditorContext.Provider>
  );
};
