import {JSXElement, children} from 'solid-js';
import {useEditorContext} from '../../context/EditorContext';
import BranchWrapper from './BranchWrapper';

/**
 * @param {Object} props
 * @param {Map<string, any>} props.chain
 * @param {string} props.type
 * @param {any} props.node
 * @param {JSXElement | (FocusActions) => JSXElement} props.children
 */
export default props => {
  const {setEditor} = useEditorContext();
  const inner = children(() => props.children);
  const type = () => props.type;
  const node = () => props.node;

  const setup = () => {
    setEditor('focus', new Map());
  };

  const update = ([type, node]) => {
    setEditor('focus', focus => new Map(focus).set(type(), node()));
  };

  const actions = {
    onFocus: setup,
    onFocusIn: [update, [type, node]],
  };

  return typeof inner() === 'function' ? (
    inner()(actions)
  ) : (
    <BranchWrapper actions={actions}>{inner()}</BranchWrapper>
  );
};
