import {createMemo, For, Show} from 'solid-js';
import {createStore, unwrap} from 'solid-js/store';
import {useDataContext} from '../../context/DataContext';
import {useEditorContext} from '../../context/EditorContext';
import DetailTemplate from '../../templates/DetailTemplate';
import SectionTemplate from '../../templates/SectionTemplate';
import Action from './Action';

export default props => {
  const {data, setData} = useDataContext();
  const [sections, setSections] = createStore(data.sections);

  const {editor, setEditor} = useEditorContext();

  const current = item => editor.focus.get(item);
  const currentRaw = item => unwrap(current(item));

  const matchSection = section => pointer => pointer === unwrap(section);
  const matchDetail = detail => pointer => pointer === unwrap(detail);

  const matchCurrentSection = () => matchSection(current('section'));
  const matchCurrentDetail = () => matchDetail(current('detail'));

  const appendSection = sections => [...sections, SectionTemplate()];
  const appendDetail = details => [...details, DetailTemplate()];

  const addSection = () => {
    setData('sections', appendSection);
  };

  const moveSection = by => {
    let fn = sections => {
      let section = current('section');
      let i = sections.indexOf(unwrap(section));

      if ((by > 0 && i > 0) || (by < 0 && i + 1 < sections.length)) {
        [sections[i - by], sections[i]] = [sections[i], sections[i - by]];

        return [...sections];
      }

      return sections;
    };

    setData('sections', fn);
  };

  const removeSection = () => {
    let section = currentRaw('section');

    let confirmed = confirm(
      section.name
        ? `Are you sure you want to remove section "${section.name}"?`
        : 'Are you sure you want to remove the selected section?'
    );

    if (confirmed) {
      /** @type {Array} */
      let sections = unwrap(data.sections);
      let index = sections.indexOf(section);

      sections.splice(index, 1);

      setData('sections', [...sections]);
    }
  };

  const addDetail = () => {
    setData(
      'sections',
      matchCurrentSection(),
      'content',
      'details',
      appendDetail
    );
  };

  /**
   * @param {number} by
   */
  const moveDetail = by => {
    /** @param {Array} details */
    let fn = details => {
      let detail = currentRaw('detail');
      let resDetail = current('detail');
      let i = details.indexOf(detail);

      if ((by > 0 && i > 0) || (by < 0 && i + 1 < details.length)) {
        [details[i - by], details[i]] = [details[i], details[i - by]];

        return [...details];
      } else {
        /** @type {Array} */
        let sections = data.sections;
        let currentSection = current('section');
        let currentSectionIndex = sections.indexOf(currentSection);

        if (by > 0 && currentSectionIndex > 0) {
          let above = currentSectionIndex - 1;

          details.splice(i, 1);

          setData(
            'sections',
            above,
            'content',
            'details',
            sections[above].content.details.length,
            detail
          );

          setEditor('focus', focus => {
            focus
              .set('section', sections[above])
              .set('details', sections[above].content.details);

            return new Map(focus);
          });

          return [...details];
        } else if (by < 0 && currentSectionIndex < sections.length - 1) {
          let below = currentSectionIndex + 1;

          details.splice(i, 1);

          setData('sections', below, 'content', 'details', details => {
            details.unshift(detail);

            return [...details];
          });

          setEditor('focus', focus => {
            focus
              .set('section', sections[below])
              .set('details', sections[below].content.details);

            return new Map(focus);
          });

          return [...details];
        }
      }

      return details;
    };

    setData('sections', matchCurrentSection(), 'content', 'details', fn);
  };

  const removeDetail = () => {
    let detail = currentRaw('detail');

    let confirmed = confirm(
      detail.heading
        ? `Are you sure you want to remove detail with heading "${detail.heading}"?`
        : 'Are you sure you want to remove the selected detail?'
    );

    if (confirmed) {
      /** @type {Array} */
      let details = currentRaw('details');
      let index = details.indexOf(detail);

      details.splice(index, 1);

      setData('sections', matchCurrentSection(), 'content', 'details', [
        ...details,
      ]);
    }
  };

  const controls = {
    section: (
      <>
        <Action run={[moveSection, 1]}>Section Up</Action>
        <Action run={[moveSection, -1]}>Section Down</Action>
        <Action run={removeSection}>Remove Section</Action>
        <Action run={addDetail}>Add Detail</Action>
      </>
    ),
    detail: (
      <>
        <Action run={[moveDetail, 1]}>Detail Up</Action>
        <Action run={[moveDetail, -1]}>Detail Down</Action>
        <Action run={removeDetail}>Remove Detail</Action>
      </>
    ),
  };

  /** @type {() => Array} */
  const nodes = createMemo(() => [...editor.focus].toReversed());

  return (
    <div class="control-bar">
      <div class="control-bar-controls">
        <div class="row">
          <div class="col-auto">
            <Action run={addSection}>Add Section</Action>
          </div>

          <For each={nodes()}>
            {([type]) => (
              <Show when={controls[type]}>
                <div class="col-auto control-bar-segment">{controls[type]}</div>
              </Show>
            )}
          </For>
        </div>
      </div>

      <div class="control-bar-breadcrumbs">
        <For each={nodes()}>
          {([type], i) => (
            <div class="">
              <span>{type}</span>{' '}
              <Show when={i() + 1 < nodes().length}>
                <span>{' > '}</span>
              </Show>
            </div>
          )}
        </For>
      </div>
    </div>
  );
};
