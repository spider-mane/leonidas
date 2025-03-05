import {children, createMemo} from 'solid-js';
import Branch from '../Editor/Branch';
import {useActionContext} from '../../context/ActionContext';
import {useInputActionsContext} from '../../context/InputActionsContext';

export default props => {
  const path = createMemo(() => props.path);

  const text = children(() => props.children);
  const {pathInput, pathSlug} = useActionContext();
  const {mirrorInput, maybeSubmitForm} = useInputActionsContext();

  /**
   * @param {KeyboardEvent} e
   */
  const onKeyDown = e => {
    if ('Enter' === e.key) {
      e.preventDefault();
      maybeSubmitForm(e.target);
    }
  };

  return (
    <Branch type={props.type} node={text()}>
      {onFocus => (
        <textarea
          class="text-input"
          name={pathInput(path())}
          id={pathSlug(path())}
          autocomplete="off"
          rows="5"
          onInput={[mirrorInput, path()]}
          onKeyDown={onKeyDown}
          {...onFocus}
        >
          {text()}
        </textarea>
      )}
    </Branch>
  );
};
