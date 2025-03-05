import Branch from '../Editor/Branch';
import Control from './Media/Control';
import {createMemo} from 'solid-js';
import {useDataContext} from '../../context/DataContext';
import {useMediaContext} from '../../context/MediaSelectorContext';
import {useActionContext} from '../../context/ActionContext';
import Field from './Field';
import Container from './Media/Container';

export default props => {
  const path = createMemo(() => props.path);
  const media = createMemo(() => props.data);

  /**
   * @type {{root: HTMLElement, media: HTMLImageElement|HTMLVideoElement}}
   */
  const refs = {root: null, media: null};

  const {openMediaFrame, openMediaViewer} = useMediaContext();
  const {pathInput} = useActionContext();
  const {setData} = useDataContext();

  const selectMedia = () => [openMediaFrame, [path(), refs.media]];
  const unsetMedia = () => setData(...path(), null);
  const openViewer = () => [openMediaViewer, media().data.src];

  const Controls = props => (
    <div class="media-edit">
      <Control action={selectMedia()} focus={props.focus}>
        Edit
      </Control>
      <Control action={unsetMedia} focus={props.focus}>
        Remove
      </Control>
      <Control action={openViewer()} focus={props.focus}>
        View
      </Control>
    </div>
  );

  return (
    <Branch type="media" node={media()}>
      {onFocus => (
        <div class="media-input-box" ref={refs.root} tabIndex="-1" {...onFocus}>
          <div class="input-title">
            <span>Media</span>
          </div>
          <div class="media-input">
            <div class="media-container">
              {media() ? (
                <>
                  <Container data={media()} ref={refs.media} />
                  <Controls focus={onFocus} />
                </>
              ) : (
                <Control action={selectMedia()} focus={onFocus} size="lg">
                  Select Media
                </Control>
              )}
            </div>
            <Field path={path()} data={media()?.data.id ?? 0} />
          </div>
        </div>
      )}
    </Branch>
  );
};
