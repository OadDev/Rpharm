@extends('layouts.app')

@section('title', 'About Us — RJS Pharma')

@push('styles')
<style>
.about-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;}
.about-grid img{border-radius:18px;}
.checklist{list-style:none;padding:0;margin:22px 0;display:grid;grid-template-columns:1fr 1fr;gap:10px;}
.checklist li{display:flex;gap:8px;align-items:flex-start;font-size:14.5px;}
.checklist li svg{flex-shrink:0;margin-top:3px;color:var(--teal);}
.stat-row{display:flex;gap:40px;margin-top:26px;flex-wrap:wrap;}
.stat-row b{font-family:'Sora';font-size:30px;color:var(--navy);display:block;}
.stat-row span{font-size:13px;color:var(--muted);}

.mvv-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
.mvv-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:30px;border-top:4px solid var(--teal);}
.mvv-card:nth-child(2){border-top-color:var(--green);}
.mvv-card:nth-child(3){border-top-color:var(--coral);}
.mvv-card h4{font-size:18px;margin-bottom:12px;}
.mvv-card p{font-size:14.5px;color:var(--muted);margin:0;}

.timeline{position:relative;padding-left:36px;border-left:2px solid var(--border);}
.tl-item{position:relative;padding-bottom:36px;}
.tl-item:last-child{padding-bottom:0;}
.tl-item::before{content:'';position:absolute;left:-44px;top:2px;width:14px;height:14px;border-radius:50%;background:var(--teal);border:3px solid var(--teal-light);}
.tl-item b{color:var(--navy);font-family:'Sora';font-size:15px;}
.tl-item p{color:var(--muted);font-size:14px;margin:4px 0 0;}

.cert-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
.cert-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:24px;text-align:center;}
.cert-card .icon{font-size:30px;margin-bottom:10px;}
.cert-card h5{font-size:14.5px;margin-bottom:4px;}
.cert-card span{font-size:12.5px;color:var(--muted);}

.leader-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
.leader-card{text-align:center;}
.leader-photo{position:relative;border-radius:16px;aspect-ratio:1/1;margin-bottom:14px;overflow:hidden;background:var(--teal-light);}
.leader-photo img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
.leader-fallback{position:absolute;inset:0;display:flex;align-items:center;justify-content:center;font-family:'Sora',sans-serif;font-weight:800;font-size:32px;color:var(--teal);}
.leader-card b{display:block;font-family:'Sora';color:var(--navy);}
.leader-card span{font-size:13px;color:var(--muted);}

@media(max-width:900px){
  .about-grid,.mvv-grid,.cert-grid,.leader-grid{grid-template-columns:1fr 1fr;}
  .checklist{grid-template-columns:1fr;}
}
@media(max-width:600px){
  .mvv-grid,.cert-grid,.leader-grid,.about-grid{grid-template-columns:1fr;}
}
</style>
@endpush

@section('content')

<div class="page-banner">
  <div class="wrap">
    <div class="eyebrow" style="color:#bfe6df"><span class="leaf-bullet" style="background:#fff"></span> ABOUT RJS PHARMA</div>
    <h1>Science. Compassion. Commitment.</h1>
    <div class="crumbs"><a href="{{ route('home') }}">Home</a> / About Us</div>
  </div>
</div>

<section>
  <div class="wrap about-grid">
    <div>
      <div class="eyebrow"><span class="leaf-bullet"></span> WHO WE ARE</div>
      <h2 style="font-size:32px;">A Pharma Leader Delivering Excellence in Medicine Development</h2>
      <p style="color:var(--muted);margin-top:16px;">RJS Pharma is a forward-thinking pharmaceutical company headquartered in New Delhi, with operations from Guwahati, Assam. We develop and market medicines across dermatology, anti-infectives, general medicine and nutraceuticals — combining scientific excellence with a deep commitment to patients.</p>
      <ul class="checklist">
        <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>Quality-Driven Products</li>
        <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>Advanced Formulation Techniques</li>
        <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>Strict Quality Control</li>
        <li><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>Trusted by Healthcare Providers</li>
      </ul>
      <div class="stat-row">
        @foreach($aboutStats as $stat)
        <div><b>{{ $stat->value }}</b><span>{{ $stat->label }}</span></div>
        @endforeach
      </div>
    </div>
    <img src="https://rjspharma.in/wp-content/uploads/2024/04/about4.jpg" alt="RJS Pharma facility">
  </div>
</section>

<section style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> OUR FOUNDATION</div>
      <h2>Mission, Vision & Values</h2>
    </div>
    <div class="mvv-grid">
      @foreach($valueProps as $vp)
      <div class="mvv-card">
        <h4>{{ $vp->title }}</h4>
        <p>{{ $vp->description }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section>
  <div class="wrap" style="display:grid;grid-template-columns:1fr 1.2fr;gap:56px;">
    <div>
      <div class="eyebrow"><span class="leaf-bullet"></span> OUR JOURNEY</div>
      <h2 style="font-size:30px;">Milestones That Shaped Us</h2>
      <p style="color:var(--muted);margin-top:14px;">A track record built one product, one partnership and one patient outcome at a time.</p>
    </div>
    <div class="timeline">
      @foreach($milestones as $m)
      <div class="tl-item"><b>{{ $m->title }}</b><p>{{ $m->description }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> QUALITY & COMPLIANCE</div>
      <h2>Built on a Foundation of Quality</h2>
      <p class="center">Every product we bring to market passes through rigorous quality checks and regulatory compliance.</p>
    </div>
    <div class="cert-grid">
      @foreach($certifications as $c)
      <div class="cert-card"><div class="icon">{{ $c->icon }}</div><h5>{{ $c->title }}</h5><span>{{ $c->subtitle }}</span></div>
      @endforeach
    </div>
  </div>
</section>

<section>
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> LEADERSHIP VOICES</div>
      <h2>Doctors Who Trust RJS Pharma</h2>
    </div>
    <div class="leader-grid">
      @foreach($testimonials as $t)
      <div class="leader-card">
        <div class="leader-photo">
          <div class="leader-fallback">{{ collect(explode(' ', $t->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('') }}</div>
          @if($t->avatar_src)
            <img src="{{ $t->avatar_src }}" alt="{{ $t->name }}" onerror="this.remove()">
          @endif
        </div>
        <b>{{ $t->name }}</b><span>{{ $t->title }}</span>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section style="background:var(--navy);border-radius:24px;max-width:var(--maxw);margin:0 auto 40px;padding:60px 40px;text-align:center;">
  <h2 style="color:#fff;font-size:26px;">Want to know more about our manufacturing process?</h2>
  <p style="color:#b9cdd6;margin:14px 0 24px;">See how a product moves from research to your pharmacy shelf.</p>
  <a href="{{ route('process') }}" class="btn btn-white">Explore Our Process →</a>
</section>

@endsection
