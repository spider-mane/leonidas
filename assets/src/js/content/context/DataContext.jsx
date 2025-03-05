import {createContext, useContext} from 'solid-js';
import {createStore} from 'solid-js/store';
import ContentTemplate from '../templates/ContentTemplate';

export const DataContext = createContext();

export const useDataContext = () => useContext(DataContext);

export const DataContextProvider = props => {
  let [data, setData] = createStore(
    props.data ? props.data : new ContentTemplate()
  );

  return (
    <DataContext.Provider value={{data, setData}}>
      {props.children}
    </DataContext.Provider>
  );
};
