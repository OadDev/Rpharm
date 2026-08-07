@extends('layouts.app')

@section('title', 'Careers — RJS Pharma')

@push('styles')
<style>
.culture-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;}
.culture-card{background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:26px;text-align:center;}
.culture-card .icon{font-size:28px;margin-bottom:10px;}
.culture-card h5{font-size:15px;margin-bottom:6px;}
.culture-card p{font-size:13px;color:var(--muted);margin:0;}

.job-list{display:flex;flex-direction:column;gap:14px;}
.job-card{
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);padding:22px 26px;
  display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;
}
.job-card h4{font-size:16.5px;margin-bottom:6px;}
.job-meta{display:flex;gap:10px;flex-wrap:wrap;}
.job-tag{font-size:12px;font-weight:700;color:var(--teal);background:var(--teal-light);padding:3px 10px;border-radius:999px;}
.job-tag.loc{color:var(--navy);background:#EEF3F6;}

.apply-wrap{background:#fff;border:1px solid var(--border);border-radius:20px;padding:40px;box-shadow:var(--shadow);}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;}
.form-grid .full{grid-column:1/-1;}
label{display:block;font-size:13.5px;font-weight:600;color:var(--navy);margin-bottom:7px;}
input[type=text],input[type=email],input[type=tel],select,textarea{
  width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:10px;font-family:'Inter';font-size:14.5px;outline:none;background:var(--bg);
}
input:focus,select:focus,textarea:focus{border-color:var(--teal);background:#fff;}
textarea{resize:vertical;min-height:100px;}
.field-error{color:var(--coral);font-size:12.5px;margin-top:6px;display:block;}

.upload-box{
  border:2px dashed var(--border);border-radius:14px;padding:28px;text-align:center;cursor:pointer;transition:.15s;background:var(--bg);
}
.upload-box:hover, .upload-box.drag{border-color:var(--teal);background:var(--teal-light);}
.upload-box svg{margin-bottom:10px;}
.upload-box .file-name{margin-top:10px;font-size:13.5px;font-weight:600;color:var(--teal);display:none;}
.upload-hint{font-size:12px;color:var(--muted);margin-top:6px;}

@media(max-width:900px){.culture-grid{grid-template-columns:1fr 1fr;}.form-grid{grid-template-columns:1fr;}}
@media(max-width:600px){.culture-grid{grid-template-columns:1fr;}.apply-wrap{padding:22px;}}
</style>
@endpush

@section('content')

<div class="page-banner">
  <div class="wrap">
    <div class="eyebrow" style="color:#bfe6df"><span class="leaf-bullet" style="background:#fff"></span> JOIN OUR TEAM</div>
    <h1>Build a Healthier Tomorrow With Us</h1>
    <p style="color:#cfe0e8;max-width:560px;margin-top:12px;">From research and formulation to sales and distribution — grow your career at a pharma company that puts patients first.</p>
    <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Careers</div>
  </div>
</div>

<section>
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> WHY RJS PHARMA</div>
      <h2>Life at RJS Pharma</h2>
    </div>
    <div class="culture-grid">
      @foreach($cultureItems as $c)
      <div class="culture-card"><div class="icon">{{ $c->icon }}</div><h5>{{ $c->title }}</h5><p>{{ $c->description }}</p></div>
      @endforeach
    </div>
  </div>
</section>

<section style="background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);">
  <div class="wrap">
    <div class="section-head">
      <div class="eyebrow"><span class="leaf-bullet"></span> CURRENT OPENINGS</div>
      <h2>Open Positions</h2>
      <p>Don't see a perfect fit? Submit your CV below and our HR team will reach out when a matching role opens.</p>
    </div>
    <div class="job-list">
      @foreach($jobOpenings as $job)
      <div class="job-card">
        <div>
          <h4>{{ $job->title }}</h4>
          <div class="job-meta"><span class="job-tag">{{ $job->department }}</span><span class="job-tag loc">{{ $job->location }}</span><span class="job-tag loc">{{ $job->employment_type }}</span></div>
        </div>
        <a href="#apply" class="btn btn-outline apply-link" data-position="{{ $job->title }}">Apply →</a>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section id="apply">
  <div class="wrap">
    <div class="section-head center">
      <div class="eyebrow center"><span class="leaf-bullet"></span> APPLICATION FORM</div>
      <h2>Apply Now</h2>
      <p class="center">Fill in your details and attach your CV — our HR team typically responds within 5 working days.</p>
    </div>
    <div class="apply-wrap">
      @if(session('applied'))
      <p id="formMsg" style="text-align:center;color:var(--teal);font-weight:600;margin-bottom:26px;">Thanks — your application has been received. Our HR team will be in touch shortly.</p>
      @else
      <form id="careerForm" method="POST" action="{{ route('careers.apply') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-grid">
          <div>
            <label>Full Name *</label>
            <input type="text" name="full_name" required placeholder="Your full name" value="{{ old('full_name') }}">
            @error('full_name')<span class="field-error">{{ $message }}</span>@enderror
          </div>
          <div>
            <label>Email Address *</label>
            <input type="email" name="email" required placeholder="you@example.com" value="{{ old('email') }}">
            @error('email')<span class="field-error">{{ $message }}</span>@enderror
          </div>
          <div>
            <label>Phone Number *</label>
            <input type="tel" name="phone" required placeholder="+91 XXXXX XXXXX" value="{{ old('phone') }}">
            @error('phone')<span class="field-error">{{ $message }}</span>@enderror
          </div>
          <div>
            <label>Position Applying For *</label>
            <select name="position" id="positionSelect" required>
              <option value="">Select a position</option>
              @foreach($jobOpenings as $job)
              <option value="{{ $job->title }}" {{ old('position') === $job->title ? 'selected' : '' }}>{{ $job->title }}</option>
              @endforeach
              <option value="Other" {{ old('position') === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('position')<span class="field-error">{{ $message }}</span>@enderror
          </div>
          <div class="full">
            <label>Upload Your CV / Resume *</label>
            <div class="upload-box" id="uploadBox" onclick="document.getElementById('cvFile').click()">
              <input type="file" id="cvFile" name="cv" accept=".pdf,.doc,.docx" style="display:none" onchange="showFileName(this)">
              <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#0F7A72" stroke-width="1.8" style="margin:0 auto;"><path d="M12 16V4M12 4l-4 4M12 4l4 4"/><path d="M4 16v3a2 2 0 002 2h12a2 2 0 002-2v-3"/></svg>
              <div><b>Click to upload</b> or drag and drop</div>
              <div class="upload-hint">PDF or Word document, up to 5MB</div>
              <div class="file-name" id="fileName"></div>
            </div>
            @error('cv')<span class="field-error">{{ $message }}</span>@enderror
          </div>
          <div class="full"><label>Cover Note (optional)</label><textarea name="cover_note" placeholder="Tell us why you'd be a great fit…">{{ old('cover_note') }}</textarea></div>
        </div>
        <div style="margin-top:26px;text-align:center;">
          <button type="submit" class="btn btn-primary" style="padding:14px 40px;">Submit Application →</button>
        </div>
      </form>
      @endif
    </div>
  </div>
</section>

@endsection

@push('scripts')
<script>
function showFileName(input){
  const nameEl = document.getElementById('fileName');
  if(input.files.length){
    nameEl.textContent = "✓ " + input.files[0].name;
    nameEl.style.display = "block";
  }
}
const box = document.getElementById('uploadBox');
if(box){
  ['dragover','dragenter'].forEach(evt=>box.addEventListener(evt,e=>{e.preventDefault();box.classList.add('drag');}));
  ['dragleave','drop'].forEach(evt=>box.addEventListener(evt,e=>{e.preventDefault();box.classList.remove('drag');}));
  box.addEventListener('drop', e=>{
    const files = e.dataTransfer.files;
    if(files.length){ document.getElementById('cvFile').files = files; showFileName(document.getElementById('cvFile')); }
  });
}
document.querySelectorAll('.apply-link').forEach(link=>{
  link.addEventListener('click', ()=>{
    const select = document.getElementById('positionSelect');
    if(select){ select.value = link.dataset.position; }
  });
});
</script>
@endpush
