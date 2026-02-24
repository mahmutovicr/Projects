const toggle = document.getElementById('billing-toggle');
const lblm = document.getElementById('lbl-monthly');
const lbla = document.getElementById('lbl-annual');

toggle.addEventListener('change', () => {
const isAnnual = toggle.checked;

lblm.classList.toggle('active', !isAnnual);
lbla.classList.toggle('active', isAnnual);

document.querySelectorAll('.amount').forEach(el => {
 const start = parseInt(el.textContent);
 const end = isAnnual ? parseInt(el.dataset.annual) : parseInt(el.dataset.monthly);
 const t0 = performance.now();
 
 const tick = now => {
 const p = Math.min((now - t0) / 420, 1);
 const ease = 1 - Math.pow(1 - p, 3);
 el.textContent = Math.round(start + (end - start) * ease);
 if (p < 1) requestAnimationFrame(tick);
 };

requestAnimationFrame(tick); 
});

const monthly = [9, 29, 79];
const annual = [7, 23, 63];

[0,1,2].forEach(i => {
const note = document.getElementById('note-' + i);
const saved = (monthly[i] - annual[i]) * 12;

note.classList.remove('show');

setTimeout(() => {
note.textContent = isAnnual
? '$' + (annual[i] * 12) + '/yr . save $' + saved
: '';
if (isAnnual) note.classList.add('show');    
}, 180);
});
});

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
if (selectedCard && selectedCard !== card){
selectedCard.classList.remove('selected');
selectedCard.style.outline = '';
selectedCard.querySelector('.btn').textContent = 'Get Started';
}

if (selectedCard === card) {
card.classList.remove('selected');
card.style.outline = '';
btn.textContent = 'Get Started'
selectedCard = null;
return;    
}

selectedCard = card;
card.classList.add('selected');
card.style.outline = '';
btn.textContent ='Selected ✓';
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


































































