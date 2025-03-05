import content from './modules/content';

const modules = {
  init: [content],
  dom: [],
  load: [],
};

modules.init.forEach(module => module());

document.addEventListener('DOMContentLoaded', function () {
  modules.dom.forEach(module => module());
});

window.addEventListener('load', function () {
  modules.load.forEach(module => module());
});
