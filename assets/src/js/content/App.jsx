import {DataContextProvider} from './context/DataContext';
import ViewContentEditor from './components/ViewContentEditor';
import {ConfigContextProvider} from './context/ConfigContext';
import {EditorContextProvider} from './context/EditorContext';
import Loader from './Loader';
import {MediaContextProvider} from './context/MediaSelectorContext';
import {ActionContextProvider} from './context/ActionContext';
import {InputActionsContextProvider} from './context/InputActionsContext';

export default props => {
  return (
    <ConfigContextProvider config={props.config}>
      <DataContextProvider data={props.data}>
        <EditorContextProvider>
          <MediaContextProvider>
            <ActionContextProvider>
              <InputActionsContextProvider>
                <Loader root={ViewContentEditor} />
              </InputActionsContextProvider>
            </ActionContextProvider>
          </MediaContextProvider>
        </EditorContextProvider>
      </DataContextProvider>
    </ConfigContextProvider>
  );
};
