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

const formSections = document.querySelectorAll('.leadsun-form-section');
const floatingActions = document.querySelectorAll('.leadsun-avatar, .leadsun-whatsapp-float');
const contentToProtect = document.querySelectorAll(
  '.home-hero__content, .entity-hero__content, .entity-card, .leadsun-form, .home-feature__content, .entity-single__description, .entity-specifications, .solution-highlight',
);

if (formSections.length && floatingActions.length) {
  if ('IntersectionObserver' in window) {
    const formObserver = new IntersectionObserver((entries) => {
      const formVisible = entries.some((entry) => entry.isIntersecting);
      floatingActions.forEach((action) => action.toggleAttribute('data-form-visible', formVisible));
    });

    formSections.forEach((section) => formObserver.observe(section));
  } else {
    floatingActions.forEach((action) => action.setAttribute('data-form-visible', ''));
  }
}

if (floatingActions.length && contentToProtect.length) {
  let overlapCheckScheduled = false;

  const checkFloatingActionOverlap = () => {
    floatingActions.forEach((action) => {
      const actionRect = action.getBoundingClientRect();
      const obscuresContent = [...contentToProtect].some((content) => {
        const contentRect = content.getBoundingClientRect();
        return contentRect.width > 0
          && contentRect.height > 0
          && actionRect.right > contentRect.left
          && actionRect.left < contentRect.right
          && actionRect.bottom > contentRect.top
          && actionRect.top < contentRect.bottom;
      });

      action.toggleAttribute('data-content-obscured', obscuresContent);
    });
  };

  const scheduleOverlapCheck = () => {
    if (overlapCheckScheduled) return;
    overlapCheckScheduled = true;
    window.requestAnimationFrame(() => {
      overlapCheckScheduled = false;
      checkFloatingActionOverlap();
    });
  };

  window.addEventListener('scroll', scheduleOverlapCheck, { passive: true });
  window.addEventListener('resize', scheduleOverlapCheck, { passive: true });
  window.addEventListener('load', scheduleOverlapCheck, { once: true });
  document.fonts?.ready.then(scheduleOverlapCheck);
  scheduleOverlapCheck();
}
