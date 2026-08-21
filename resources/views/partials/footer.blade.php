<footer class="site" id="contact">
  <div class="wrap">
    <div class="footer-grid">
      <div>
        <div class="foot-brand">@if($settings['logo_url'] ?? null)<img src="{{ $settings['logo_url'] }}" alt="RJS Pharma" onerror="this.remove()">@endif RJS Pharma</div>
        <p>{{ $settings['footer_tagline'] ?? '' }}</p>
      </div>
      <div>
        <h4>Our Offices</h4>
        @foreach($offices as $office)
        <p><b style="color:#fff">{{ $office->city }}:</b> {{ $office->address }}</p>
        @endforeach
      </div>
      <div>
        <h4>Contact</h4>
        <a href="tel:{{ str_replace(' ', '', $settings['phone_primary'] ?? '') }}">{{ $settings['phone_primary'] ?? '' }}</a>
        <a href="tel:{{ str_replace(' ', '', $settings['phone_secondary'] ?? '') }}">{{ $settings['phone_secondary'] ?? '' }}</a>
        <a href="mailto:{{ $settings['email'] ?? '' }}">{{ $settings['email'] ?? '' }}</a>
      </div>
      <div>
        <h4>Quick Links</h4>
        <a href="{{ route('about') }}">About Us</a>
        <a href="{{ route('products.index') }}">Our Products</a>
        <a href="{{ route('process') }}">Our Process</a>
        <a href="{{ route('careers.index') }}">Careers</a>
      </div>
    </div>
    <div class="foot-bottom">
      <span>© {{ now()->year }} RJS Pharma. All Rights Reserved.</span>
      <span>Developed by <a href="https://orbitxmedia.com" target="_blank" rel="noopener noreferrer">Orbit X Media Pvt. Ltd.</a></span>
    </div>
  </div>
</footer>
