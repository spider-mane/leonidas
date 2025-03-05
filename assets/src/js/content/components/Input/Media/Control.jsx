export default props => (
  <button
    class="media-action"
    type="button"
    onClick={props.action}
    {...props.focus}
  >
    {props.children}
  </button>
);
