import Label from './Input/Label';

export default props => {
  return (
    <div class="row text-input-row">
      <div class="col-2 text-input-row-column">
        <div class="input-title">
          {(props.useLabel ?? true) ? (
            <Label path={props.path}>{props.title}</Label>
          ) : (
            <span>{props.title}</span>
          )}
        </div>
      </div>
      <div class="col">
        <div class="">{props.children}</div>
      </div>
    </div>
  );
};
