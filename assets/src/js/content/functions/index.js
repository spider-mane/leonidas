/**
 * @param {Array<string|number>} path
 *
 * @returns {string}
 */
export function listToInput(path) {
  let name = path.shift();

  path.forEach(node => {
    name += `[${node}]`;
  });

  return name;
}

/**
 * @param {Array<string|number>} path
 *
 * @returns {string}
 */
export function listToSlug(path) {
  return path.join('-');
}

/**
 * @param {HTMLFormElement} form
 * @param {HTMLTextAreaElement} input
 */
export function pushFormSubmission(form, input) {
  form.dispatchEvent(
    new SubmitEvent('submit', {
      submitter: input,
    })
  );

  form.submit();
}
