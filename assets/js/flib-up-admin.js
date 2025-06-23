import { initElementsBuilder } from './builder/elements.js';
import { initPreview } from './builder/preview.js';
import { initModals } from './builder/modals.js';
import { initStyles } from './builder/styles.js';
import { initMedia } from './builder/media.js';

document.addEventListener('DOMContentLoaded', () => {
    initElementsBuilder();
    initPreview();
    initModals();
    initStyles();
    initMedia();
});