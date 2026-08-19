<header class="site">
  <div class="nav">
    <a href="{{ route('home') }}" class="brand">
      @if($settings['logo_url'] ?? null)
        <img src="{{ $settings['logo_url'] }}" alt="RJS Pharma" onerror="this.remove();document.getElementById('brandFallback').style.display='inline'">
      @endif
      <span id="brandFallback" style="{{ ($settings['logo_url'] ?? null) ? 'display:none' : '' }}">RJS Pharma</span>
    </a>
    <nav class="navlinks">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
      <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Our Products</a>
      <a href="{{ route('process') }}" class="{{ request()->routeIs('process') ? 'active' : '' }}">Our Process</a>
      <a href="{{ route('careers.index') }}" class="{{ request()->routeIs('careers.*') ? 'active' : '' }}">Careers</a>
      <a href="#contact">Contact</a>
    </nav>
    <div class="nav-cta">
      <a href="{{ request()->routeIs('careers.*') ? '#apply' : '#contact' }}" class="btn btn-primary">{{ request()->routeIs('careers.*') ? 'Apply Now' : 'Get In Touch' }}</a>
    </div>
    <button class="hamburger" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">
      <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#0B2D4E" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
  <nav class="navlinks-mobile" id="navMobile">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
    <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">Our Products</a>
    <a href="{{ route('process') }}" class="{{ request()->routeIs('process') ? 'active' : '' }}">Our Process</a>
    <a href="{{ route('careers.index') }}" class="{{ request()->routeIs('careers.*') ? 'active' : '' }}">Careers</a>
    <a href="#contact">Contact</a>
  </nav>
</header>
