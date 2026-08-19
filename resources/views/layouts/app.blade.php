<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'RJS Pharma — Innovating Medicines, Elevating Lives')</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
@stack('styles')
</head>
<body>

@include('partials.nav')

@yield('content')

@include('partials.footer')

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
