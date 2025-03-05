import {useActionContext} from '../../context/ActionContext';

/**
 * @param {Object} props
 * @param {Array<string|number>} props.path
 * @param {string|number} props.data
 */
export default props => {
  const {pathInput} = useActionContext();

  return (
    <input type="hidden" name={pathInput(props.path)} value={props.data} />
  );
};
