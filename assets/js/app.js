/**
 * LEADSUN application entry point.
 * No jQuery dependency.
 */

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
