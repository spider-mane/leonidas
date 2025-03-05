import {children, Show} from 'solid-js';

export default function ViewSegment(props) {
  const nodes = children(() => props.children);

  return (
    <div class="view-section" classList={{'has-focus': true}}>
      <Show when={nodes().before}>{nodes().before}</Show>
      <div class="section-input-header">
        <div class="row">
          <div class="col-8">
            <div class="section-info">
              <div class="section-title-container">
                <div class="section-title">{nodes().title}</div>
              </div>
              <Show when={nodes().reference}>
                <div class="section-reference-container">
                  {/* <span>Reference: </span> */}
                  <span>{nodes().reference}</span>
                </div>
              </Show>
              <Show when={nodes().description}>
                <div class="section-description-container">
                  {nodes().description}
                </div>
              </Show>
            </div>
          </div>
          <div class="col"></div>
        </div>
      </div>

      <hr class="section-editor-header-divider" />

      <div class="section-content">{nodes().content}</div>
      <Show when={nodes().after}>{nodes().after}</Show>
    </div>
  );
}
