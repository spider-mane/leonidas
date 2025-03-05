/**
 * @param
 */
export default ({run, children}) => {
  return (
    <button class="control-bar-button" type="button" onClick={run}>
      {children}
    </button>
  );
};
