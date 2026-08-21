<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'RJS Pharma — Innovating Medicines, Elevating Lives')</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
@stack('styles')
<style>
.img-modal{position:fixed;inset:0;z-index:999;display:none;align-items:center;justify-content:center;padding:24px;}
.img-modal.open{display:flex;}
.img-modal-backdrop{position:absolute;inset:0;background:rgba(15,42,68,.82);}
.img-modal-content{position:relative;background:#fff;border-radius:16px;padding:20px;max-width:480px;width:100%;max-height:85vh;display:flex;flex-direction:column;gap:14px;z-index:1;box-shadow:0 20px 60px rgba(0,0,0,.3);}
.img-modal-media{width:100%;aspect-ratio:1/1;border-radius:12px;overflow:hidden;background:var(--bg,#f4f7f8);display:flex;align-items:center;justify-content:center;}
.img-modal-media img{width:100%;height:100%;object-fit:contain;}
.img-modal-swatch{width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#fff;font-family:'Sora',sans-serif;font-weight:800;font-size:22px;text-align:center;padding:20px;}
.img-modal-close{position:absolute;top:12px;right:12px;width:34px;height:34px;border-radius:50%;border:none;background:var(--bg,#f4f7f8);color:var(--navy,#0f2a44);font-size:20px;cursor:pointer;line-height:1;}
.img-modal-caption{font-family:'Sora',sans-serif;font-weight:700;color:var(--navy,#0f2a44);text-align:center;font-size:16px;}

.wa-widget{position:fixed;right:20px;bottom:20px;z-index:998;display:flex;flex-direction:column;align-items:flex-end;gap:14px;font-family:'Inter',sans-serif;}
.wa-fab{width:58px;height:58px;border-radius:50%;background:#25D366;border:none;display:flex;align-items:center;justify-content:center;box-shadow:0 6px 18px rgba(0,0,0,.28);cursor:pointer;flex-shrink:0;transition:transform .15s;}
.wa-fab:hover{transform:scale(1.06);}
.wa-fab svg{width:30px;height:30px;}
.wa-fab .wa-icon-close{display:none;}
.wa-widget.open .wa-fab .wa-icon-chat{display:none;}
.wa-widget.open .wa-fab .wa-icon-close{display:block;}
.wa-panel{display:none;flex-direction:column;width:320px;max-width:calc(100vw - 40px);background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 16px 48px rgba(0,0,0,.28);}
.wa-widget.open .wa-panel{display:flex;}
.wa-panel-header{background:#25D366;color:#fff;padding:16px 18px;display:flex;align-items:center;gap:10px;font-weight:700;font-size:15px;}
.wa-panel-header svg{width:22px;height:22px;flex-shrink:0;}
.wa-panel-body{background:#e7ddd2;padding:18px;min-height:100px;}
.wa-bubble{background:#fff;border-radius:10px;padding:10px 14px;font-size:14px;color:#111;max-width:88%;box-shadow:0 1px 2px rgba(0,0,0,.12);}
.wa-bubble-time{display:block;font-size:11px;color:#8a97a2;margin-top:6px;}
.wa-panel-form{display:flex;gap:8px;padding:12px;background:#fff;border-top:1px solid var(--border,#e4e9ec);}
.wa-panel-form input{flex:1;border:1px solid var(--border,#e4e9ec);border-radius:999px;padding:10px 16px;font-size:14px;outline:none;font-family:inherit;}
.wa-panel-form input:focus{border-color:#25D366;}
.wa-panel-form button{width:38px;height:38px;border-radius:50%;border:none;background:#25D366;color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;}
@media(max-width:480px){.wa-widget{right:14px;bottom:14px;}}
</style>
</head>
<body>

@include('partials.nav')

@yield('content')

@include('partials.footer')

<div class="img-modal" id="imgModal" aria-hidden="true">
  <div class="img-modal-backdrop" onclick="closeImgModal()"></div>
  <div class="img-modal-content" role="dialog" aria-modal="true">
    <button type="button" class="img-modal-close" onclick="closeImgModal()" aria-label="Close">&times;</button>
    <div class="img-modal-media" id="imgModalMedia"></div>
    <div class="img-modal-caption" id="imgModalCaption"></div>
  </div>
</div>

<div class="wa-widget" id="waWidget">
  <div class="wa-panel" role="dialog" aria-label="Chat on WhatsApp">
    <div class="wa-panel-header">
      <svg viewBox="0 0 32 32" fill="#fff"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.4.7 4.6 1.9 6.5L4 29l7.7-1.8c1.9 1 4 1.6 6.3 1.6 6.6 0 12-5.4 12-12S22.6 3 16 3zm0 22c-2 0-3.9-.5-5.5-1.5l-.4-.2-4.6 1.1 1.1-4.5-.3-.4C5.2 17.9 4.6 16 4.6 15c0-6.3 5.1-11.4 11.4-11.4S27.4 8.7 27.4 15 22.3 25 16 25z"/><path d="M22 18.2c-.3-.2-1.9-1-2.2-1.1-.3-.1-.5-.2-.7.2-.2.3-.8 1.1-1 1.3-.2.2-.4.3-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-2-1.8-2.3-.2-.3 0-.5.1-.6.1-.1.3-.4.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5s-.7-1.6-.9-2.2c-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.2-.6-.4z"/></svg>
      <span>Let's chat on WhatsApp</span>
    </div>
    <div class="wa-panel-body">
      <div class="wa-bubble">
        Greetings from RJS PHARMA, how may I help you ?
        <span class="wa-bubble-time" id="waTime"></span>
      </div>
    </div>
    <form class="wa-panel-form" id="waForm">
      <input type="text" id="waMessage" placeholder="Write your message…" autocomplete="off">
      <button type="submit" aria-label="Send">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff"><path d="M2 21l21-9L2 3v7l15 2-15 2z"/></svg>
      </button>
    </form>
  </div>
  <button type="button" class="wa-fab" id="waFab" aria-label="Chat on WhatsApp">
    <svg class="wa-icon-chat" viewBox="0 0 32 32" fill="#fff"><path d="M16 3C9.4 3 4 8.4 4 15c0 2.4.7 4.6 1.9 6.5L4 29l7.7-1.8c1.9 1 4 1.6 6.3 1.6 6.6 0 12-5.4 12-12S22.6 3 16 3zm0 22c-2 0-3.9-.5-5.5-1.5l-.4-.2-4.6 1.1 1.1-4.5-.3-.4C5.2 17.9 4.6 16 4.6 15c0-6.3 5.1-11.4 11.4-11.4S27.4 8.7 27.4 15 22.3 25 16 25z"/><path d="M22 18.2c-.3-.2-1.9-1-2.2-1.1-.3-.1-.5-.2-.7.2-.2.3-.8 1.1-1 1.3-.2.2-.4.3-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-2-1.8-2.3-.2-.3 0-.5.1-.6.1-.1.3-.4.4-.5.1-.2.2-.3.3-.5.1-.2 0-.4 0-.5s-.7-1.6-.9-2.2c-.2-.5-.5-.5-.7-.5h-.6c-.2 0-.5.1-.8.4-.3.3-1 1-1 2.4s1 2.8 1.2 3c.1.2 2.1 3.2 5.1 4.5.7.3 1.3.5 1.7.6.7.2 1.4.2 1.9.1.6-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.2-.6-.4z"/></svg>
    <svg class="wa-icon-close" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5"><path d="M6 6l12 12M18 6L6 18"/></svg>
  </button>
</div>

<script>
function openImgModal(src, name, gradStart, gradEnd){
  var media = document.getElementById('imgModalMedia');
  if (src) {
    media.innerHTML = '';
    var img = document.createElement('img');
    img.src = src;
    img.alt = name || '';
    media.appendChild(img);
  } else {
    media.innerHTML = '';
    var swatch = document.createElement('div');
    swatch.className = 'img-modal-swatch';
    swatch.style.background = 'linear-gradient(135deg,' + gradStart + ',' + gradEnd + ')';
    swatch.textContent = (name || '').toUpperCase();
    media.appendChild(swatch);
  }
  document.getElementById('imgModalCaption').textContent = name || '';
  var modal = document.getElementById('imgModal');
  modal.classList.add('open');
  modal.setAttribute('aria-hidden', 'false');
  document.body.style.overflow = 'hidden';
}
function closeImgModal(){
  var modal = document.getElementById('imgModal');
  modal.classList.remove('open');
  modal.setAttribute('aria-hidden', 'true');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeImgModal(); });
</script>

<script>
(function(){
  var WHATSAPP_NUMBER = '919435381001';
  var widget = document.getElementById('waWidget');
  var fab = document.getElementById('waFab');
  var form = document.getElementById('waForm');
  var input = document.getElementById('waMessage');
  var timeEl = document.getElementById('waTime');
  if (! widget || ! fab || ! form || ! input) return;

  if (timeEl) {
    timeEl.textContent = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
  }

  fab.addEventListener('click', function(){
    widget.classList.toggle('open');
  });

  form.addEventListener('submit', function(e){
    e.preventDefault();
    var msg = input.value.trim();
    var url = 'https://wa.me/' + WHATSAPP_NUMBER + (msg ? '?text=' + encodeURIComponent(msg) : '');
    window.open(url, '_blank', 'noopener');
    input.value = '';
  });
})();
</script>

<script>
(function(){
  var btn = document.getElementById('navToggle');
  var panel = document.getElementById('navMobile');
  if(!btn || !panel) return;
  btn.addEventListener('click', function(){
    var open = panel.classList.toggle('open');
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
  panel.querySelectorAll('a').forEach(function(a){
    a.addEventListener('click', function(){ panel.classList.remove('open'); btn.setAttribute('aria-expanded','false'); });
  });
})();
</script>
@stack('scripts')
</body>
</html>
