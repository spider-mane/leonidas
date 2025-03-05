/**
 * @param {Object} props
 * @param {Map} props.each
 * @param {(value, key, map: Map) => import("solid-js").JSXElement} props.children
 */
export default ({each, children}) => {
  console.log(each);

  return <>{each.forEach(children)}</>;
};
