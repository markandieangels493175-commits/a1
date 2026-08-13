const body = document.body;
const reduceMotion = matchMedia('(prefers-reduced-motion: reduce)').matches;
const menu = document.querySelector('.lab-menu');
const nav = document.querySelector('.lab-nav');

function setNavigation(open) {
  body.classList.toggle('nav-open', open);
  menu?.setAttribute('aria-expanded', String(open));
  nav?.setAttribute('aria-hidden', String(!open));
}
menu?.addEventListener('click', () => setNavigation(!body.classList.contains('nav-open')));
nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => setNavigation(false)));
addEventListener('keydown', event => { if (event.key === 'Escape') setNavigation(false); });

body.classList.add('motion-ready');
const targets = [...document.querySelectorAll('main > section, .long-note > section')];
targets.forEach(target => target.classList.add('motion-section'));
if (!reduceMotion && 'IntersectionObserver' in window) {
  const observer = new IntersectionObserver(entries => entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('in-view');
      observer.unobserve(entry.target);
    }
  }), { threshold: .08, rootMargin: '0px 0px -5%' });
  targets.forEach(target => observer.observe(target));
} else targets.forEach(target => target.classList.add('in-view'));

let queued = false;
function updateProgress() {
  const max = document.documentElement.scrollHeight - innerHeight;
  document.documentElement.style.setProperty('--scroll', `${max > 0 ? scrollY / max * 100 : 0}%`);
  queued = false;
}
addEventListener('scroll', () => {
  if (!queued) { requestAnimationFrame(updateProgress); queued = true; }
}, { passive: true });
updateProgress();

const curve = document.querySelector('[data-curve]');
const dot = curve?.querySelector('.curve-dot');
const cursor = curve?.querySelector('.curve-cursor');
const phase = document.querySelector('[data-phase]');
const temperature = document.querySelector('[data-temp]');
const phases = [
  ['PREHEAT', '180°C'], ['RISE', '210°C'], ['SEAR', '225°C'],
  ['RECOVER', '190°C'], ['FINISH', '205°C'], ['REST', '72°C']
];
curve?.addEventListener('pointermove', event => {
  const rect = curve.getBoundingClientRect();
  const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
  const index = Math.min(phases.length - 1, Math.floor(x * phases.length));
  if (phase) phase.textContent = phases[index][0];
  if (temperature) temperature.textContent = phases[index][1];
  if (cursor) cursor.style.left = `${x * 100}%`;
  if (dot) {
    dot.setAttribute('cx', String(50 + x * 800));
    const y = 385 - Math.sin(x * Math.PI) * 210 + Math.sin(x * Math.PI * 5) * 55;
    dot.setAttribute('cy', String(Math.max(80, Math.min(390, y))));
  }
});

document.querySelectorAll('[data-filter]').forEach(button => button.addEventListener('click', () => {
  document.querySelectorAll('[data-filter]').forEach(item => item.classList.remove('active'));
  button.classList.add('active');
  document.querySelectorAll('.experiment-grid article').forEach(card => {
    const visible = button.dataset.filter === 'all' || card.dataset.cat === button.dataset.filter;
    card.classList.toggle('hide', !visible);
    card.classList.remove('filter-pop');
    if (visible) requestAnimationFrame(() => card.classList.add('filter-pop'));
  });
}));

document.querySelector('.contact-lab form')?.addEventListener('submit', event => {
  event.preventDefault();
  const status = event.currentTarget.querySelector('.form-status');
  if (status) status.textContent = 'Signal prepared. The lab will respond by email.';
  event.currentTarget.reset();
});

const consent = document.querySelector('.consent');
if (localStorage.getItem('cml-consent')) consent?.classList.add('hidden');
document.querySelectorAll('[data-consent]').forEach(button => button.addEventListener('click', () => {
  const analytics = button.dataset.consent === 'accept' ? 'granted' : 'denied';
  if (typeof gtag === 'function') gtag('consent', 'update', {
    analytics_storage: analytics,
    ad_storage: 'denied',
    ad_user_data: 'denied',
    ad_personalization: 'denied'
  });
  localStorage.setItem('cml-consent', analytics);
  consent?.classList.add('hidden');
}));
