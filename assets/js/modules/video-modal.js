const isSafeEmbedUrl = (value) => {
  try {
    const url = new URL(value);
    return url.protocol === 'https:'
      && url.hostname === 'www.youtube-nocookie.com'
      && /^\/embed\/[A-Za-z0-9_-]{11}$/.test(url.pathname);
  } catch {
    return false;
  }
};

const resetModal = (modal) => {
  const frame = modal.querySelector('[data-video-modal-frame]');
  if (frame) {
    frame.replaceChildren();
  }
  modal.hidden = true;
};

export function initVideoModals() {
  const triggers = document.querySelectorAll('[data-video-modal-trigger]');
  if (!triggers.length) {
    return;
  }

  const closeModal = (modal) => {
    resetModal(modal);
  };

  triggers.forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const modal = document.getElementById(trigger.dataset.videoModalTarget);
      const embedUrl = trigger.dataset.videoEmbedUrl;
      const frame = modal?.querySelector('[data-video-modal-frame]');

      if (!modal || !frame || !isSafeEmbedUrl(embedUrl)) {
        return;
      }

      const iframe = document.createElement('iframe');
      iframe.src = embedUrl;
      iframe.title = trigger.dataset.videoTitle || 'Video';
      iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
      iframe.allowFullscreen = true;
      frame.replaceChildren(iframe);
      modal.hidden = false;
      modal.querySelector('[data-video-modal-close]')?.focus();
    });
  });

  document.querySelectorAll('[data-video-modal]').forEach((modal) => {
    modal.querySelectorAll('[data-video-modal-close]').forEach((button) => {
      button.addEventListener('click', () => closeModal(modal));
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
      return;
    }

    document.querySelectorAll('[data-video-modal]:not([hidden])').forEach(closeModal);
  });
}
