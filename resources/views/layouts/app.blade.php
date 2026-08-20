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
