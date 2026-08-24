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

const playbackUrl = (embedUrl) => {
  const url = new URL(embedUrl);
  url.search = new URLSearchParams({ autoplay: '1', mute: '1', rel: '0', playsinline: '1', modestbranding: '1', controls: '0' }).toString();
  return url.toString();
};

const mountInlineVideo = (element) => {
  const frame = element.querySelector('[data-video-inline-frame]');
  const embedUrl = element.dataset.videoEmbedUrl;
  if (!frame || frame.childElementCount || !isSafeEmbedUrl(embedUrl)) return;

  const iframe = document.createElement('iframe');
  iframe.src = playbackUrl(embedUrl);
  iframe.title = element.dataset.videoTitle || 'Video';
  iframe.allow = 'autoplay; encrypted-media; picture-in-picture';
  iframe.tabIndex = -1;
  frame.replaceChildren(iframe);
  element.classList.add('is-playing');
};

const unmountInlineVideo = (element) => {
  const frame = element.querySelector('[data-video-inline-frame]');
  if (frame) frame.replaceChildren();
  element.classList.remove('is-playing');
};

export function initInlineVideos() {
  const videos = document.querySelectorAll('[data-video-inline]');
  if (!videos.length) return;

  videos.forEach((video) => {
    video.querySelector('[data-video-inline-trigger]')?.addEventListener('click', () => mountInlineVideo(video));
  });

  if (!('IntersectionObserver' in window)) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-observed');
        mountInlineVideo(entry.target);
      } else {
        unmountInlineVideo(entry.target);
      }
    });
  }, { rootMargin: '160px 0px' });

  videos.forEach((video) => observer.observe(video));
}
