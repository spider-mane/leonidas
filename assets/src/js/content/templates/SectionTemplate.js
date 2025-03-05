import DetailTemplate from './DetailTemplate';

export default () => ({
  name: '',
  description: '',
  reference: '',
  content: {
    main: new DetailTemplate(),
    details: [],
  },
});
