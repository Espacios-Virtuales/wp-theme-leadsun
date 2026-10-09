export function initNavigation() {
  const nav = document.getElementById('site-navigation');
  const toggle = document.querySelector('.menu-toggle');
  const mobileQuery = window.matchMedia('(max-width: 991.98px)');

  if (!nav || !toggle) {
    return;
  }

  if (toggle.dataset.navigationInitialized === 'true') {
    return;
  }

  toggle.dataset.navigationInitialized = 'true';

  const setExpanded = (expanded) => {
    toggle.setAttribute('aria-expanded', String(expanded));
    toggle.setAttribute(
      'aria-label',
      expanded ? toggle.dataset.labelClose : toggle.dataset.labelOpen,
    );
    nav.classList.toggle('is-open', expanded);
  };

  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    setExpanded(!expanded);
  });

  nav.addEventListener('click', (event) => {
    if (event.target.closest('a') && mobileQuery.matches) {
      setExpanded(false);
    }
  });

  nav.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setExpanded(false);
      toggle.focus();
    }
  });

  mobileQuery.addEventListener('change', (event) => {
    if (!event.matches) {
      setExpanded(false);
    }
  });
}
