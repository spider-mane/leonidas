/**
 * @param {Object} props
 * @param {Object} props.actions
 * @param {import("solid-js").JSXElement} props.children
 */
export default props => (
  <div tabIndex="-1" {...props.actions}>
    {props.children}
  </div>
);
