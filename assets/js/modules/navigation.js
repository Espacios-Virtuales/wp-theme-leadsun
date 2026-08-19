export function initNavigation() {
  const nav = document.getElementById('site-navigation');
  const toggle = document.querySelector('.menu-toggle');

  if (!nav || !toggle) {
    return;
  }

  toggle.addEventListener('click', () => {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    nav.classList.toggle('is-open', !expanded);
  });
}
