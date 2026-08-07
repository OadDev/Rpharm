@extends('layouts.app')

@section('title', 'Our Process — RJS Pharma')

@push('styles')
<style>
.proc-list{display:flex;flex-direction:column;gap:0;}
.proc-item{display:grid;grid-template-columns:70px 1fr;gap:24px;padding:32px 0;border-bottom:1px solid var(--border);position:relative;}
.proc-item:last-child{border-bottom:none;}
.proc-num{font-family:'Sora';font-weight:800;font-size:34px;color:var(--teal-light);-webkit-text-stroke:1.5px var(--teal);color:transparent;}
.proc-body h4{font-size:19px;margin-bottom:8px;}
.proc-body p{color:var(--muted);font-size:14.5px;margin:0;max-width:640px;}
.proc-tag{display:inline-block;margin-top:10px;font-size:12px;font-weight:700;color:var(--teal);background:var(--teal-light);padding:3px 10px;border-radius:999px;}

.split{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;}
.split img{border-radius:18px;}

.condition-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
.condition-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;}
.condition-card h5{font-size:15.5px;margin-bottom:8px;}
.condition-card p{font-size:13.5px;color:var(--muted);margin:0;}

.contact-strip{display:flex;justify-content:space-between;align-items:center;background:#fff;border:1px solid var(--border);border-radius:18px;padding:26px 32px;flex-wrap:wrap;gap:16px;}
.contact-strip .item{display:flex;gap:10px;align-items:center;font-size:14.5px;color:var(--navy);font-weight:600;}
@media(max-width:900px){.split,.condition-grid{grid-template-columns:1fr;}}
@media(max-width:600px){.proc-item{grid-template-columns:44px 1fr;gap:14px;}.proc-num{font-size:24px;}}
</style>
@endpush

@section('content')

<div class="page-banner">
  <div class="wrap">
    <div class="eyebrow" style="color:#bfe6df"><span class="leaf-bullet" style="background:#fff"></span> WORKING PROCESS</div>
    <h1>From Research to Your Pharmacy Shelf</h1>
    <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Our Process</div>
  </div>
</div>

<section>
  <div class="wrap">
    <div class="section-head">
      <h2>Our Development Process for Effective Medicines</h2>
      <p>Every RJS Pharma product passes through six disciplined stages — ensuring the highest quality standards and effective outcomes for patients, before it ever reaches a pharmacy shelf.</p>
    </div>
    <div class="proc-list">
      @foreach($steps as $step)
      <div class="proc-item">
        <div class="proc-num">{{ str_pad($step->step_number, 2, '0', STR_PAD_LEFT) }}</div>
        <div class="proc-body">
          <h4>{{ $step->title }}</h4>
          <p>{{ $step->description }}</p>
          @if($step->tag)<span class="proc-tag">{{ $step->tag }}</span>@endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="wrap split">
    <img src="https://rjspharma.in/wp-content/uploads/2024/04/process.jpg" alt="RJS Pharma manufacturing process">
    <div>
      <div class="eyebrow"><span class="leaf-bullet"></span> WHAT WE TREAT</div>
      <h2 style="font-size:28px;">Solutions Across the Care Spectrum</h2>
      <p style="color:var(--muted);margin:16px 0 24px;">Our medicines address a broad spectrum of conditions — from acute infections and inflammatory flare-ups that need fast relief, to chronic dermatological and respiratory conditions that require ongoing management.</p>
      <div class="condition-grid" style="grid-template-columns:1fr 1fr;">
        <div class="condition-card"><h5>Acute Care</h5><p>Infections, allergic flare-ups and inflammatory conditions needing prompt treatment.</p></div>
        <div class="condition-card"><h5>Chronic Management</h5><p>Ongoing dermatological, respiratory and metabolic conditions managed over time.</p></div>
      </div>
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="contact-strip">
      <div class="item">📞 <a href="tel:{{ str_replace(' ', '', $settings['phone_process'] ?? '') }}">{{ $settings['phone_process'] ?? '' }}</a></div>
      <div class="item">✉️ <a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a></div>
      <div class="item">📍 Guwahati, Assam &amp; New Delhi</div>
      <a href="{{ route('home') }}#contact" class="btn btn-primary">Contact Our Team →</a>
    </div>
  </div>
</section>

@endsection
