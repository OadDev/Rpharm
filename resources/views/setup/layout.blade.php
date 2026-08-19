<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Setup') — RJS Pharma Setup Wizard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
<style>
body{background:var(--bg);min-height:100vh;}
.setup-shell{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 18px;}
.setup-card{width:100%;max-width:680px;background:#fff;border:1px solid var(--border);border-radius:20px;box-shadow:var(--shadow);padding:44px;}
.setup-brand{display:flex;align-items:center;gap:10px;font-family:'Sora',sans-serif;font-weight:800;font-size:19px;color:var(--navy);margin-bottom:28px;}
.setup-brand .leaf-bullet{width:12px;height:12px;}

.setup-steps{display:flex;justify-content:space-between;margin-bottom:36px;position:relative;}
.setup-steps::before{content:'';position:absolute;top:15px;left:0;right:0;height:2px;background:var(--border);z-index:0;}
.setup-step{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;gap:8px;flex:1;}
.setup-step .dot{width:30px;height:30px;border-radius:50%;background:#fff;border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;color:var(--muted);}
.setup-step span{font-size:11px;font-weight:600;color:var(--muted);text-align:center;}
.setup-step.active .dot{border-color:var(--teal);color:var(--teal);background:var(--teal-light);}
.setup-step.active span{color:var(--navy);}
.setup-step.done .dot{border-color:var(--teal);background:var(--teal);color:#fff;}
.setup-step.done span{color:var(--navy);}

.setup-card h1{font-size:24px;margin-bottom:8px;}
.setup-card .lead{color:var(--muted);font-size:14.5px;margin-bottom:28px;}

.setup-alert{padding:14px 18px;border-radius:12px;font-size:13.5px;font-weight:600;margin-bottom:22px;}
.setup-alert.error{background:#FDEEEC;color:#B03A2C;border:1px solid #F3C9C2;}
.setup-alert.success{background:var(--teal-light);color:var(--teal);border:1px solid #bfe6df;}

.check-list{list-style:none;padding:0;margin:0 0 28px;display:flex;flex-direction:column;gap:8px;}
.check-list li{display:flex;align-items:center;gap:10px;font-size:13.5px;padding:10px 14px;border-radius:10px;background:var(--bg);border:1px solid var(--border);}
.check-list li b{margin-left:auto;font-size:11px;text-transform:uppercase;letter-spacing:.04em;}
.check-list li.pass{border-color:#cdeadf;}
.check-list li.pass b{color:var(--green);}
.check-list li.fail{border-color:#f3c9c2;background:#FDEEEC;}
.check-list li.fail b{color:#B03A2C;}
.check-icon{width:20px;height:20px;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;color:#fff;}
.check-list li.pass .check-icon{background:var(--green);}
.check-list li.fail .check-icon{background:#E85D4C;}

.setup-form label{display:block;font-size:13.5px;font-weight:600;color:var(--navy);margin-bottom:7px;}
.setup-form input,.setup-form select{
  width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;font-family:'Inter';font-size:14.5px;outline:none;background:var(--bg);margin-bottom:18px;
}
.setup-form input:focus,.setup-form select:focus{border-color:var(--teal);background:#fff;}
.setup-form .field-error{display:block;color:#B03A2C;font-size:12px;margin:-14px 0 16px;}
.setup-form .two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px;}

.setup-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:8px;}
.setup-note{font-size:12.5px;color:var(--muted);margin-top:18px;}

.install-log{background:var(--navy);color:#cfe0e8;border-radius:12px;padding:18px;font-family:monospace;font-size:12.5px;white-space:pre-wrap;max-height:260px;overflow:auto;margin-bottom:22px;}

.setup-finish{text-align:center;padding:20px 0;}
.setup-finish .icon{width:64px;height:64px;border-radius:50%;background:var(--teal-light);color:var(--teal);display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:32px;}

@media(max-width:600px){
  .setup-card{padding:28px 20px;}
  .setup-steps span{display:none;}
  .setup-form .two-col{grid-template-columns:1fr;}
}
</style>
</head>
<body>
<div class="setup-shell">
  <div class="setup-card">
    <div class="setup-brand"><span class="leaf-bullet"></span> RJS Pharma — Setup Wizard</div>

    <div class="setup-steps">
      @php($steps = ['Requirements','Database','Install','Admin Account','Finish'])
      @foreach($steps as $i => $label)
        @php($n = $i + 1)
        <div class="setup-step {{ $n < ($currentStep ?? 1) ? 'done' : ($n === ($currentStep ?? 1) ? 'active' : '') }}">
          <div class="dot">{{ $n < ($currentStep ?? 1) ? '✓' : $n }}</div>
          <span>{{ $label }}</span>
        </div>
      @endforeach
    </div>

    @if(session('error'))
      <div class="setup-alert error">{{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</div>
</body>
</html>
