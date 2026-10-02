/**
 * LEADSUN application entry point.
 * No jQuery dependency.
 */

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!reduceMotion && window.AOS && typeof window.AOS.init === 'function') {
  document.querySelectorAll('.leadsun-form[data-aos]').forEach((form) => {
    if (form.querySelector('.leadsun-field--error, .leadsun-form__notice--error, [aria-invalid="true"]')) {
      form.removeAttribute('data-aos');
    }
  });

  window.AOS.init({
    duration: 650,
    easing: 'ease-out',
    once: true,
    offset: 60,
  });
  document.documentElement.classList.add('aos-enabled');
}

import('./modules/navigation.js')
  .then(({ initNavigation }) => initNavigation())
  .catch(() => {
    // Keep the public page usable even if a progressive enhancement module fails.
  });

import('./modules/video-modal.js')
  .then(({ initVideoModals }) => initVideoModals())
  .catch(() => {
    // Video triggers remain inert if this progressive enhancement module fails.
  });

import('./modules/video-inline.js')
  .then(({ initInlineVideos }) => initInlineVideos())
  .catch(() => {
    // Poster and manual inline trigger remain available without observer support.
  });
