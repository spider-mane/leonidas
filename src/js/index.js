import MetaBox from './models/MetaBox';
import * as metaBoxView from './views/metaBoxView';
import {
    elements,
    jQueryElements,
    wpPages
} from "./views/base";

// window.elements = elements;

const state = {};
window.state = state;

if (window.pagenow === wpPages.editPostLocation) {

    // Remove Platfrom url input from DOM and thusly POST
    elements.platformUrlContainer.addEventListener('click', function (e) {
        if (e.target.dataset.backalleyLocationPlatform) {
            e.preventDefault();

            let confirmationMessage = "Are you sure you want to remove this platform? If you save after removing it, the url associated with it for this location will be permanantly deleted.";

            if (window.confirm(confirmationMessage)) {
                document.getElementById(e.target.dataset.backalleyLocationPlatform).remove();
            }
        }
    });

    // Insert new Platform url input
    elements.newPlatformButton.addEventListener('click', function (e) {
        e.preventDefault();
        metaBoxView.insertNewPlatformUrlInput();
    });

}