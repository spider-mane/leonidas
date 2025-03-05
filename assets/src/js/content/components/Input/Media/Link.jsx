export default props => {
  return (
    <div class="select-media-link">
      <a href="#" onClick={props.openSelector} {...props.onFocus}>
        Select Media
      </a>
    </div>
  );
};
