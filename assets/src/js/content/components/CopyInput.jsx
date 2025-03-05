import {children, createMemo} from 'solid-js';
import Branch from './Editor/Branch';
import Media from './Input/Media';
import Paragraph from './Input/Paragraph';
import SimpleText from './Input/SimpleText';
import Field from './Input/Field';
import Label from './Input/Label';
import InputRow from './InputRow';

/**
 * @typedef {text: string, link: string} Action
 */

/**
 * @typedef {{
 *  id: int,
 *  kicker: string,
 *  heading: string,
 *  subheading: string,
 *  body: string,
 *  action: Action,
 * }} CopyStatement
 */

/**
 * @param {{path: Array<string|number>, data: CopyStatement}} props
 */
export default function CopyInput(props) {
  const path = createMemo(() => props.path);
  const copy = createMemo(() => props.data);

  const paths = {
    kicker: () => [...path(), 'kicker'],
    heading: () => [...path(), 'heading'],
    subheading: () => [...path(), 'subheading'],
    body: () => [...path(), 'body'],
    action: {
      text: () => [...path(), 'action', 'text'],
      link: () => [...path(), 'action', 'link'],
    },
  };

  const refs = {
    root: null,
  };

  return (
    <div class="copy-input-row" classList={{'has-focus': true}}>
      <Field path={[...path(), 'id']} data={copy()?.id ?? 0} />
      <div class="row">
        <div class="col-9">
          <InputRow title="Kicker" path={paths.kicker()}>
            <SimpleText
              type="kicker"
              path={paths.kicker()}
              value={copy().kicker ?? ''}
            />
          </InputRow>

          <InputRow title="Heading" path={paths.heading()}>
            <SimpleText
              type="heading"
              path={paths.heading()}
              value={copy().heading ?? ''}
            />
          </InputRow>

          <InputRow title="Subheading" path={paths.subheading()}>
            <SimpleText
              type="subheading"
              path={paths.subheading()}
              value={copy().subheading ?? ''}
            />
          </InputRow>

          <InputRow title="Body" path={paths.body()}>
            <Paragraph type="body" path={paths.body()}>
              {copy().body}
            </Paragraph>
          </InputRow>

          <InputRow title="Action" path={paths.action.text()} useLabel={false}>
            <Branch type="action" node={copy().action}>
              <div class="row">
                <div class="col-5">
                  <SimpleText
                    type="text"
                    path={paths.action.text()}
                    value={copy().action?.text ?? ''}
                  />
                  <div class="text-input-partial">
                    <Label path={paths.action.text()}>Text</Label>
                  </div>
                </div>
                <div class="col">
                  <SimpleText
                    type="link"
                    path={paths.action.link()}
                    value={copy().action?.link ?? ''}
                  />
                  <div class="text-input-partial">
                    <Label path={paths.action.link()}>Link</Label>
                  </div>
                </div>
              </div>
            </Branch>
          </InputRow>
        </div>
        <div class="col-3">
          <Media data={copy().media} path={[...path(), 'media']} />
        </div>
      </div>
    </div>
  );
}
