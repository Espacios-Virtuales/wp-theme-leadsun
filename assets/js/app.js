/**
 * LEADSUN application entry point.
 * No jQuery dependency.
 */

import('./modules/navigation.js')
  .then(({ initNavigation }) => initNavigation())
  .catch(() => {
    // Keep the public page usable even if a progressive enhancement module fails.
  });
