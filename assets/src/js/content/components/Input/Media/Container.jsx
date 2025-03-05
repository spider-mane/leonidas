import {Dynamic} from 'solid-js/web';
import Picture from './Picture';
import Video from './Video';
import {createMemo} from 'solid-js';

/**
 * @type {Object<string, import('solid-js').JSXElement>}
 */
const handlers = {
  picture: Picture,
  video: Video,
};

export default props => {
  const media = createMemo(() => props.data);

  return (
    <Dynamic
      component={handlers[media().type]}
      data={media().data}
      ref={props.ref}
    />
  );
};
