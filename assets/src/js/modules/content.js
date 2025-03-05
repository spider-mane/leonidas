import content from '../content';

const selector = '.leonidas-view-content-editor';

export default () => {
  document.querySelectorAll(selector).forEach(editor => content(editor));
};
