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
  modal._leadsunTrigger?.focus();
};

const playbackUrl = (embedUrl) => {
  const url = new URL(embedUrl);
  url.search = new URLSearchParams({
    autoplay: '1',
    mute: '1',
    rel: '0',
    playsinline: '1',
    modestbranding: '1',
    controls: '1',
  }).toString();
  return url.toString();
};

export function initVideoModals() {
  const triggers = document.querySelectorAll('[data-video-modal-trigger]');
  if (!triggers.length) {
    return;
  }

  const closeModal = (modal) => {
    resetModal(modal);
  };

  const openModal = (modal, embedUrl, title, trigger) => {
    const frame = modal?.querySelector('[data-video-modal-frame]');
    if (!modal || !frame || !isSafeEmbedUrl(embedUrl)) {
      return;
    }

    const iframe = document.createElement('iframe');
    iframe.src = playbackUrl(embedUrl);
    iframe.title = title || 'Video';
    iframe.allow = 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share';
    iframe.allowFullscreen = true;
    modal._leadsunTrigger = trigger;
    frame.replaceChildren(iframe);
    modal.hidden = false;
    modal.querySelector('[data-video-modal-close]')?.focus();
  };

  triggers.forEach((trigger) => {
    trigger.addEventListener('click', () => {
      const modal = document.getElementById(trigger.dataset.videoModalTarget);
      const embedUrl = trigger.dataset.videoEmbedUrl;
      openModal(modal, embedUrl, trigger.dataset.videoTitle, trigger);
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

  document.querySelectorAll('[data-video-modal-auto-open]').forEach((modal) => {
    const trigger = Array.from(triggers).find((item) => item.dataset.videoModalTarget === modal.id);
    if (trigger && !modal.dataset.videoModalAutoOpened) {
      modal.dataset.videoModalAutoOpened = 'true';
      openModal(modal, trigger.dataset.videoEmbedUrl, trigger.dataset.videoTitle, trigger);
    }
  });
}
