import {createContext, useContext} from 'solid-js';
import {useEditorContext} from './EditorContext';
import {useDataContext} from './DataContext';
import {Fancybox} from '@fancyapps/ui';

const imageMimes = [
  'image/jpeg',
  'image/png',
  'image/gif',
  'image/webp',
  'image/svg+xml',
];
const videoMimes = [
  'video/mp4',
  'video/webm',
  'video/ogg',
  'video/mpeg',
  'video/quicktime',
];

const isImage = mimeType => imageMimes.includes(mimeType);
const isVideo = mimeType => videoMimes.includes(mimeType);
const getType = mimeType => (isImage(mimeType) ? 'picture' : 'video');

export const MediaContext = createContext();

/**
 * @returns {{
 *  openMediaFrame: (args: [Array, (HTMLImageElement|HTMLVideoElement)]) => void
 *  openMediaViewer: (src: string) => void
 * }}
 */
export const useMediaContext = () => useContext(MediaContext);

export const MediaContextProvider = props => {
  let frame;
  let current;

  const {editor} = useEditorContext();
  const {setData} = useDataContext();

  const openMediaFrame = ([path, ref]) => {
    current = {path, ref};

    if (!frame) {
      initMediaFrame();
    }

    frame.open();
  };

  const initMediaFrame = () => {
    frame = wp
      .media({
        frame: 'select',
        title: 'Select Copy Media',
        multiple: false,
        library: {
          type: null,
        },
        button: {
          text: 'Confirm',
        },
      })
      .on('select', updateSelection);
  };

  const updateSelection = () => {
    let selection = frame.state().get('selection').first().toJSON();

    setData(...current.path, {
      type: getType(selection.mime),
      data: {
        id: selection.id,
        mime: selection.mime,
        src: selection.url,
        sizes: selection.sizes,
      },
    });

    if (current.ref instanceof HTMLVideoElement) {
      current.ref.load();
    }

    current = undefined;
  };

  const openMediaViewer = src => new Fancybox([{src}]);

  return (
    <MediaContext.Provider value={{openMediaFrame, openMediaViewer}}>
      {props.children}
    </MediaContext.Provider>
  );
};
