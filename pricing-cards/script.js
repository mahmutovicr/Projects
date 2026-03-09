const track = document.getElementById('tri-track');
const knob = document.getElementById('tri-knob');
const lblMonthly = document.getElementById('lbl-monthly');
const lblAnnual = document.getElementById('lbl-annual');

const monthly = [9, 29, 79];
const annual = [7, 23, 63];

let currentMode = 'monthly';

function setMode(mode) {
  currentMode = mode;
  knob.classList.remove('pos-monthly', 'pos-neutral', 'pos-annual');
  knob.classList.add('pos-' + mode);
  lblMonthly.classList.toggle('active', mode === 'monthly');
  lblAnnual.classList.toggle('active', mode === 'annual');

  const isAnnual = mode === 'annual';

  document.querySelectorAll('.amount').forEach((el, i) => {
    const start = parseInt(el.textContent);
    const end = isAnnual ? annual[i] : monthly[i];
    const t0 = performance.now();
    const tick = now => {
      const p = Math.min((now - t0) / 420, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(start + (end - start) * ease);
      if (p < 1) requestAnimationFrame(tick);
    };
    requestAnimationFrame(tick);
  });

  document.querySelectorAll('.annual-note').forEach((noteEl, i) => {
    noteEl.classList.remove('show');
    setTimeout(() => {
      noteEl.textContent = isAnnual
        ? '$' + (annual[i] * 12) + '/yr · save $' + ((monthly[i] - annual[i]) * 12)
        : '';
      if (isAnnual) noteEl.classList.add('show');
    }, 180);
  });
}

track.addEventListener('click', e => {
  const rect = track.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const third = rect.width / 3;
  if (x < third) setMode('monthly');
  else if (x < third * 2) setMode('neutral');
  else setMode('annual');
});

lblMonthly.addEventListener('click', () => setMode('monthly'));
lblAnnual.addEventListener('click', () => setMode('annual'));

let selectedCard = null;

document.querySelectorAll('.card .btn').forEach(btn => {
  const card = btn.closest('.card');

  btn.addEventListener('mouseenter', () => {
    if (card === selectedCard) return;
    card.style.outline = '2px solid rgba(74,222,128,0.45)';
  });

  btn.addEventListener('mouseleave', () => {
    if (card === selectedCard) return;
    card.style.outline = '';
  });

  btn.addEventListener('click', () => {
    if (selectedCard && selectedCard !== card) {
      selectedCard.classList.remove('selected');
      selectedCard.style.outline = '';
      selectedCard.querySelector('.btn').textContent = 'Get Started';
    }

    if (selectedCard === card) {
      card.classList.remove('selected');
      card.style.outline = '';
      btn.textContent = 'Get Started';
      selectedCard = null;
      return;
    }

    selectedCard = card;
    card.classList.add('selected');
    card.style.outline = '';
    btn.textContent = 'Selected ✓';
  });
});

document.querySelectorAll('.btn').forEach(btn => {
  btn.addEventListener('mousedown', () => {
    btn.style.transition = 'opacity .08s';
    btn.style.opacity = '.6';
  });

  ['mouseup', 'mouseleave'].forEach(ev =>
    btn.addEventListener(ev, () => {
      btn.style.opacity = '1';
    })
  );
});

setMode('monthly');
