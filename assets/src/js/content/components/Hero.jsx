import {createMemo} from 'solid-js';
import CopyInput from './CopyInput';
import Branch from './Editor/Branch';
import ViewSegment from './ViewSegment';

export default props => {
  const copy = createMemo(() => props.data);

  return (
    <Branch type="hero" node={copy()}>
      <ViewSegment>
        {{
          title: 'Page Introduction (Hero)',
          content: <CopyInput data={copy()} path={props.path} />,
        }}
      </ViewSegment>
    </Branch>
  );
};
