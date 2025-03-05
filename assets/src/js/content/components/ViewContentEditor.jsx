import {createMemo, createSignal, For, Show} from 'solid-js';
import Panel from './Editor/Panel';
import Hero from './Hero';
import Section from './Section';
import {Swapy} from 'swapy-solid';

export default props => {
  const data = createMemo(() => props.data);

  /** @type {() => Array} */
  const sections = () => data().sections;

  const [partition, togglePartition] = createSignal(true);

  return (
    <div class="view-composer" ref={props.setRoot}>
      <div class="row">
        <div class="col-12">
          <div class="control-bar-container">
            <Panel />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="composition-container" tabIndex="-1" ref={props.setBase}>
            <div class="composition">
              <div class="view-hero">
                <Hero data={data().hero} path={['hero']} />
              </div>
              <div class="view-sections">
                <For each={sections()}>
                  {(section, i) => (
                    <>
                      <div class="view-section-container" draggable="false">
                        <Section data={section} path={['sections', i()]} />
                      </div>
                      <Show when={partition() && i() + 1 < sections().length}>
                        <hr class="section-partition"></hr>
                      </Show>
                    </>
                  )}
                </For>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
