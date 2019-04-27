import {
    elements
} from './base';

export const insertNewPlatformUrlInput = () => {

    let platform = elements.newPlatformInput.value;

    if (!platform) {
        return;
    }

    // band-aid af find better solution
    let wpSanitizeKeyRegex = /[^a-z0-9_\-]/
    let platformSlug = platform.toLowerCase().replace(wpSanitizeKeyRegex, '');
    platformSlug = platform;

    // Container
    let newPlatform = elements.platfromUrlTemplate.cloneNode(true);
    //   let newPlatformId = ;
    newPlatform.id = newPlatform.dataset.idFormat.replace('%platform_name%', platformSlug);
    newPlatform.removeAttribute('hidden');
    newPlatform.removeAttribute('data-id-format');

    newPlatform.querySelectorAll('*').forEach(element => {

        element.childNodes.forEach(child => {
            if (child.nodeType === 3) {
                child.textContent = child.textContent.replace('%platform_title%', platform);
            }
        })

        if (element.attributes.length > 0) {
            Array.from(element.attributes).forEach(attr => {
                attr.value = attr.value.replace('%platform_name%', platformSlug);
                attr.value = attr.value.replace('%platform_title%', platform);
            })
        }

        if (element.hasAttribute('disabled')) {
            element.removeAttribute('disabled');
        }

    })

    //    Label
    //   let label = newPlatform.querySelector('label');
    //   let labelFor = label.getAttribute('for').replace('%platform_name%', platformSlug);
    //   label.textContent = platform;
    //   label.setAttribute('for', labelFor);

    //    Text Input
    //   let input = newPlatform.querySelector('input');
    //   Array.from(input.attributes).forEach(attr => {
    //     attr.value = attr.value.replace('%platform_name%', platformSlug);
    //   });
    //   input.removeAttribute('disabled');

    //    Delete Button
    //   let deleteButton = newPlatform.querySelector('[value="Remove"]');
    //   Array.from(deleteButton.attributes).forEach(attr => {
    //     attr.value = attr.value.replace('%platform_name%', platformSlug);
    //   });

    //    Hidden name="tax_input..." Input
    //   let hiddenTax = newPlatform.querySelector('[name="tax_input[ba_delivery_platforms][]"]');
    //   let hiddenTaxVal = hiddenTax.getAttribute('value').replace('%platform_title%', platform);
    //   hiddenTax.removeAttribute('disabled');
    //   hiddenTax.setAttribute('value', hiddenTaxVal);

    //   console.log(newPlatform);

    elements.platformUrlContainer.insertAdjacentElement('beforeend', newPlatform);
    elements.newPlatformInput.value = '';
}