import DetailTemplate from './DetailTemplate';
import SectionTemplate from './SectionTemplate';

export default () => ({
  hero: new DetailTemplate(),
  sections: [new SectionTemplate()],
});
