import {createEffect, createMemo, createSignal, For, Show} from 'solid-js';
import CopyInput from './CopyInput';
import Branch from './Editor/Branch';
import {Swapy, SwapyHandle, SwapyItem, SwapySlot} from 'swapy-solid';
import {memo} from 'solid-js/web';
import {useActionContext} from '../context/ActionContext';
import Field from './Input/Field';
import ViewSegment from './ViewSegment';
import {useInputActionsContext} from '../context/InputActionsContext';
import slugify from 'voca/slugify';
import {utils} from 'swapy';
import {unwrap} from 'solid-js/store';

export default props => {
  const path = createMemo(() => props.path);
  const paths = {
    name: () => [...path(), 'name'],
    description: () => [...path(), 'description'],
    reference: () => [...path(), 'reference'],
  };

  const section = createMemo(() => props.data);
  const content = createMemo(() => section().content);
  const main = () => content().main;
  const details = () => content().details;

  const currentReference = section().reference;

  const {pathInput, pathSlug} = useActionContext();
  const {mirrorInput} = useInputActionsContext();

  /**
   * @type {Object<string, HTMLElement}
   */
  const refs = {
    root: null,
  };

  /**
   * @param {HTMLElement} el
   */
  const align = el => {
    el.scrollIntoView({behavior: 'smooth', block: 'start'});
  };

  const autoReference = () => slugify(section().name);

  const segmentNodes = () => ({
    before: <Field path={[...path(), 'id']} data={section()?.id ?? 0} />,
    title: (
      <Branch type="name" node={section().name}>
        {onFocus => (
          <input
            class="section-title"
            type="text"
            name={pathInput(paths.name())}
            id={pathSlug(paths.name())}
            placeholder="Section Name"
            value={section().name}
            autocomplete="off"
            onInput={[mirrorInput, paths.name()]}
            {...onFocus}
          />
        )}
      </Branch>
    ),
    reference: (
      <Branch type="reference" node={section().reference}>
        {onFocus => (
          <input
            class="section-reference"
            type="text"
            name={pathInput(paths.reference())}
            id={pathSlug(paths.reference())}
            placeholder="section-reference"
            value={section().reference || autoReference()}
            autocomplete="off"
            pattern="^[a-z0-9]+(-[a-z0-9]+)*$"
            title="Reference can only contain letters, numbers, and dashes."
            required
            readonly={currentReference}
            onInput={[mirrorInput, paths.reference()]}
            {...onFocus}
          />
        )}
      </Branch>
    ),
    description: (
      <Branch type="description" node={section().description}>
        {onFocus => (
          <input
            class="section-description"
            type="text"
            name={pathInput(paths.description())}
            id={pathSlug(paths.description())}
            placeholder="Description"
            value={section().description}
            autocomplete="off"
            onInput={[mirrorInput, paths.description()]}
            {...onFocus}
          />
        )}
      </Branch>
    ),
    content: (
      <>
        <Show when={main()}>
          <Branch type="main" node={main()}>
            <div class="section-main">
              <div class="section-main-title">
                <h3>Main</h3>
              </div>
              <div class="section-main-content">
                <CopyInput
                  data={main()}
                  path={[...path(), 'content', 'main']}
                />
              </div>
            </div>
          </Branch>
        </Show>

        <Show when={details().length > 0}>
          <Branch type="details" node={details()}>
            <div class="section-details">
              <div class="section-details-title">
                <h3>Details</h3>
              </div>
              <div class="section-details-content">
                <For each={details()}>
                  {(detail, i) => (
                    <Branch type="detail" node={detail}>
                      <div class="section-detail">
                        <CopyInput
                          data={detail}
                          path={[...path(), 'content', 'details', i()]}
                        />
                      </div>
                    </Branch>
                  )}
                </For>
              </div>
            </div>
          </Branch>
        </Show>
      </>
    ),
  });

  return (
    <Branch type="section" node={section()}>
      <ViewSegment children={segmentNodes()} />
    </Branch>
  );
};
