import {useActionContext} from '../../context/ActionContext';

export default props => {
  const {pathSlug} = useActionContext();

  return (
    <label class="view-input-label" for={pathSlug(props.path)}>
      {props.children}
    </label>
  );
};
