import {useDataContext} from './context/DataContext';
import {Dynamic} from 'solid-js/web';
import {useEditorContext} from './context/EditorContext';

export default props => {
  const {data, setData} = useDataContext();
  const {setEditor} = useEditorContext();

  const setRootElement = el => setEditor('root', el);
  const setBaseElement = el => setEditor('base', el);

  return (
    <Dynamic
      component={props.root}
      data={data}
      setData={setData}
      setRoot={setRootElement}
      setBase={setBaseElement}
    />
  );
};
