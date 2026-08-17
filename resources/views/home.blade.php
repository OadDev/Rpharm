@extends('layouts.app')

@section('title', 'RJS Pharma — Innovating Medicines, Elevating Lives')

@push('styles')
<style>
/* HERO */
.hero{padding:56px 0 70px;}
.hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center;}
.hero h1{font-size:clamp(34px,4.6vw,54px);font-weight:800;line-height:1.08;letter-spacing:-.01em;}
.hero h1 span{color:var(--teal);}
.hero p.lead{color:var(--muted);font-size:17px;max-width:520px;margin:20px 0 30px;}
.hero-ctas{display:flex;gap:14px;flex-wrap:wrap;}
.hero-media{position:relative;}
.hero-media img{border-radius:22px;box-shadow:var(--shadow);}
.hero-badge{
  position:absolute;bottom:-22px;left:-22px;background:#fff;border-radius:16px;
  box-shadow:var(--shadow);padding:16px 20px;display:flex;gap:12px;align-items:center;
  border:1px solid var(--border);
}
.hero-badge b{display:block;font-family:'Sora',sans-serif;color:var(--navy);font-size:20px;}
.hero-badge span{font-size:12.5px;color:var(--muted);}
.hero-dots{position:absolute;top:-30px;right:-20px;width:110px;height:110px;background:radial-gradient(circle,var(--green) 2px,transparent 2px);background-size:14px 14px;opacity:.5;z-index:-1;}

/* USP strip */
.usp-strip{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:46px 0;}
.usp-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:30px;}
.usp{display:flex;gap:14px;align-items:flex-start;}
.usp-icon{width:48px;height:48px;border-radius:12px;background:var(--teal-light);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.usp h4{font-size:16px;margin-bottom:6px;}
.usp p{font-size:13.8px;color:var(--muted);margin:0;}

/* Therapeutic areas */
.areas-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:20px;}
.area-card{
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);
  padding:26px 20px;transition:.2s;border-top:3px solid var(--accent,var(--teal));
}
.area-card:hover{transform:translateY(-4px);box-shadow:var(--shadow);}
.area-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;background:var(--teal-light);}
.area-card h4{font-size:16px;margin-bottom:8px;}
.area-card p{font-size:13.5px;color:var(--muted);margin:0 0 12px;}
.area-card a{font-size:13px;font-weight:700;color:var(--teal);}

/* Products */
.products-strip{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);}
.prod-header{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:36px;flex-wrap:wrap;gap:16px;}
.prod-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:20px;}
.prod-card{
  border:1px solid var(--border);border-radius:var(--radius);padding:20px;background:var(--bg);
  display:flex;flex-direction:column;gap:10px;position:relative;
}
.prod-tag{
  align-self:flex-start;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;
  padding:4px 10px;border-radius:999px;background:var(--teal-light);color:var(--teal);
}
.prod-swatch{
  height:90px;border-radius:10px;display:flex;align-items:center;justify-content:center;
  font-family:'Sora',sans-serif;font-weight:800;font-size:15px;color:#fff;text-align:center;padding:8px;
  position:relative;overflow:hidden;
}
.prod-swatch img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;}
.prod-card h4{font-size:15px;line-height:1.3;}
.prod-card .pack{font-size:12.5px;color:var(--muted);}
.prod-card a.details{font-size:13px;font-weight:700;color:var(--navy);margin-top:auto;display:flex;align-items:center;gap:4px;}

/* Doctor stories */
.stories-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
.story-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:30px;box-shadow:var(--shadow);}
.quote-mark{font-family:'Sora',sans-serif;font-size:44px;color:var(--teal);line-height:.5;display:block;margin-bottom:10px;}
.story-card p.txt{font-size:15px;color:var(--ink);margin-bottom:22px;}
.story-person{display:flex;align-items:center;gap:12px;}
.story-person img{width:48px;height:48px;border-radius:50%;object-fit:cover;}
.story-person b{display:block;font-size:14.5px;color:var(--navy);}
.story-person span{font-size:12.5px;color:var(--muted);}

/* Stats band */
.stats-band{background:var(--navy);color:#fff;padding:50px 0;}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;text-align:center;}
.stats-grid b{font-family:'Sora',sans-serif;font-size:36px;display:block;color:#fff;}
.stats-grid span{font-size:13.5px;color:#9fc0cc;}

@media(max-width:1000px){
  .hero-grid{grid-template-columns:1fr;}
  .usp-grid,.areas-grid,.prod-grid{grid-template-columns:repeat(2,1fr);}
  .stories-grid{grid-template-columns:1fr;}
  .stats-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:600px){
  .usp-grid,.areas-grid,.prod-grid,.stats-grid{grid-template-columns:1fr;}
}
</style>
@endpush

@section('content')

<!-- 1. OVERVIEW / HERO -->
<section class="hero">
  <div class="wrap hero-grid">
    <div>
      <div class="eyebrow"><span class="leaf-bullet"></span> ABOUT RJS PHARMA</div>
      <h1>Innovating Medicines,<br><span>Elevating Lives.</span></h1>
      <p class="lead">RJS Pharma is dedicated to developing innovative, quality-driven medicines across dermatology, anti-infectives, nutraceuticals and general medicine — bringing precision-formulated, trusted pharmaceutical solutions to healthcare providers and patients across India.</p>
      <div class="hero-ctas">
        <a href="{{ route('products.index') }}" class="btn btn-primary">Our Products →</a>
        <a href="{{ route('about') }}" class="btn btn-outline">About Us</a>
      </div>
    </div>
    <div class="hero-media">
      <div class="hero-dots"></div>
      <img src="https://rjspharma.in/wp-content/uploads/2024/03/about.png" alt="RJS Pharma research and development">
      <div class="hero-badge">
        <div class="leaf-bullet" style="width:14px;height:14px;"></div>
        <div><b>{{ $settings['hero_badge_value'] ?? '22+' }}</b><span>{{ $settings['hero_badge_label'] ?? '' }}</span></div>
      </div>
    </div>
  </div>
</section>

<!-- 2. USPs -->
<section class="usp-strip">
  <div class="wrap usp-grid">
    @foreach($uspItems as $usp)
    <div class="usp">
      <div class="usp-icon">
        @switch($usp->icon_key)
          @case('shield')
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F7A72" stroke-width="2"><path d="M12 2l7 4v6c0 5-3.5 8-7 10-3.5-2-7-5-7-10V6l7-4z"/><path d="M9 12l2 2 4-4"/></svg>
            @break
          @case('users')
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F7A72" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/></svg>
            @break
          @case('bulb')
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F7A72" stroke-width="2"><path d="M9 18h6M10 22h4M12 2a6 6 0 00-4 10.4c.6.6 1 1.4 1 2.3v.3h6v-.3c0-.9.4-1.7 1-2.3A6 6 0 0012 2z"/></svg>
            @break
          @case('globe')
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0F7A72" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 010 18 14 14 0 010-18z"/></svg>
            @break
        @endswitch
      </div>
      <div><h4>{{ $usp->title }}</h4><p>{{ $usp->description }}</p></div>
    </div>
    @endforeach
  </div>
</section>

<!-- 3. THERAPEUTIC AREAS -->
<section>
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow"><span class="leaf-bullet"></span> THERAPEUTIC AREAS</div>
      <h2>Focused on What Matters Most</h2>
      <p>Our product portfolio spans the therapeutic areas India's patients and prescribers need most, from everyday skin conditions to systemic infections.</p>
    </div>
    <div class="areas-grid">
      @foreach($categories as $cat)
      <div class="area-card" style="--accent:{{ $cat->accent_color }}">
        <div class="area-icon">{{ $cat->icon }}</div>
        <h4>{{ $cat->name }}</h4>
        <p>{{ $cat->description }}</p>
        <a href="{{ route('products.index', ['cat' => $cat->slug]) }}">View products →</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 4. OUR PRODUCTS -->
<section class="products-strip">
  <div class="wrap">
    <div class="prod-header">
      <div class="section-head" style="margin-bottom:0;">
        <div class="eyebrow"><span class="leaf-bullet"></span> OUR PRODUCTS</div>
        <h2>Our Top Products</h2>
      </div>
      <a href="{{ route('products.index') }}" class="btn btn-outline">View All Products →</a>
    </div>
    <div class="prod-grid">
      @foreach($featuredProducts as $product)
      <div class="prod-card">
        <span class="prod-tag">{{ $product->category->name }}</span>
        <div class="prod-swatch" @if(! $product->image_url) style="background:linear-gradient(135deg,{{ $product->gradient_start }},{{ $product->gradient_end }});" @endif>
          @if($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
          @else
            {{ strtoupper($product->name) }}
          @endif
        </div>
        <h4>{{ $product->name }}</h4>
        <span class="pack">{{ $product->pack_size }} · {{ $product->composition }}</span>
        <a class="details" href="{{ route('products.index', ['q' => $product->name]) }}">View details →</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- STATS -->
<section class="stats-band">
  <div class="wrap stats-grid">
    @foreach($homeStats as $stat)
    <div><b>{{ $stat->value }}</b><span>{{ $stat->label }}</span></div>
    @endforeach
  </div>
</section>

<!-- 5. REAL DOCTOR STORIES -->
<section>
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> REAL DOCTOR STORIES</div>
      <h2>Trusted by the Healthcare Providers We Serve</h2>
      <p>Our reputation is built on delivering results — hear directly from the doctors who prescribe RJS Pharma medicines every day.</p>
    </div>
    <div class="stories-grid">
      @foreach($testimonials as $t)
      <div class="story-card">
        <span class="quote-mark">&ldquo;</span>
        <p class="txt">{{ $t->quote }}</p>
        <div class="story-person">
          <img src="{{ $t->avatar_src }}" alt="{{ $t->name }}">
          <div><b>{{ $t->name }}</b><span>{{ $t->title }}</span></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
