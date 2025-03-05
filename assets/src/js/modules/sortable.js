import {Sortable, MultiDrag, AutoScroll} from 'sortablejs';

export default () => {
  // Sortable.mount(new MultiDrag(), new AutoScroll());
  Sortable.mount(new MultiDrag());
};
