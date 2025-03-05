import {createMemo} from 'solid-js';
import {useActionContext} from '../../context/ActionContext';
import Branch from '../Editor/Branch';
import {useInputActionsContext} from '../../context/InputActionsContext';

/**
 * @param {{
 *  type: string,
 *  path: string|Array<string|int>,
 *  value: string
 *  autocomplete: 'on'|'off'
 * }} props
 */
export default props => {
  const path = createMemo(() => props.path);

  const {pathInput, pathSlug} = useActionContext();
  const {mirrorInput} = useInputActionsContext();

  return (
    <Branch type={props.type} node={props.value}>
      {onFocus => (
        <input
          class="text-input"
          type="text"
          name={pathInput(path())}
          value={props.value}
          id={pathSlug(path())}
          autocomplete={props.autocomplete ?? 'off'}
          onInput={[mirrorInput, path()]}
          {...onFocus}
        />
      )}
    </Branch>
  );
};
