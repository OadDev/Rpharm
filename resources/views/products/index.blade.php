@extends('layouts.app')

@section('title', 'Our Products — RJS Pharma')

@push('styles')
<style>
.toolbar{background:#fff;border:1px solid var(--border);border-radius:18px;padding:22px;box-shadow:var(--shadow);margin-top:-58px;position:relative;z-index:5;}
.search-row{display:flex;gap:12px;}
.search-row input{
  flex:1;padding:13px 18px;border-radius:999px;border:1.5px solid var(--border);font-family:'Inter';font-size:15px;outline:none;
}
.search-row input:focus{border-color:var(--teal);}
.search-row button{border:none;background:var(--teal);color:#fff;padding:0 22px;border-radius:999px;font-weight:600;cursor:pointer;}
.cat-filters{display:flex;gap:10px;flex-wrap:wrap;margin-top:16px;}
.cat-chip{
  padding:8px 16px;border-radius:999px;border:1.5px solid var(--border);font-size:13.5px;font-weight:600;
  cursor:pointer;background:#fff;color:var(--navy);transition:.15s;
}
.cat-chip.active,.cat-chip:hover{background:var(--navy);color:#fff;border-color:var(--navy);}

.count-row{display:flex;justify-content:space-between;align-items:center;margin:36px 0 22px;color:var(--muted);font-size:14.5px;flex-wrap:wrap;gap:8px;}
.product-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;}
.pcard{
  background:#fff;border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;
  display:flex;flex-direction:column;transition:.2s;
}
.pcard:hover{box-shadow:var(--shadow);transform:translateY(-3px);}
.pcard-media{height:150px;display:flex;align-items:center;justify-content:center;font-family:'Sora';font-weight:800;color:#fff;font-size:18px;text-align:center;padding:10px;position:relative;}
.pcard-tag{position:absolute;top:10px;left:10px;background:rgba(255,255,255,.92);color:var(--navy);font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.03em;padding:4px 10px;border-radius:999px;}
.pcard-body{padding:18px 18px 6px;}
.pcard-body h4{font-size:16px;margin-bottom:4px;}
.pcard-body .comp{font-size:13px;color:var(--muted);}
.pcard-body .pack{font-size:12.5px;color:var(--teal);font-weight:700;margin-top:6px;display:block;}
.pcard-toggle{
  width:100%;background:none;border:none;border-top:1px solid var(--border);margin-top:14px;padding:13px 18px;
  display:flex;justify-content:space-between;align-items:center;cursor:pointer;font-weight:600;font-size:13.5px;color:var(--navy);
}
.pcard-toggle svg{transition:.2s;}
.pcard-toggle.open svg{transform:rotate(180deg);}
.pcard-detail{max-height:0;overflow:hidden;transition:max-height .25s ease;padding:0 18px;}
.pcard-detail.open{max-height:260px;padding-bottom:18px;}
.pcard-detail p{font-size:13.5px;color:var(--muted);margin:0 0 8px;}
.pcard-detail ul{margin:0;padding-left:18px;font-size:13px;color:var(--ink);}
.no-results{text-align:center;padding:60px 0;color:var(--muted);display:none;}
@media(max-width:900px){.product-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:600px){.product-grid{grid-template-columns:1fr;}.toolbar{margin-top:-36px;}.search-row{flex-direction:column;}.search-row button{padding:12px;}}
</style>
@endpush

@section('content')

<div class="page-banner">
  <div class="wrap">
    <div class="eyebrow" style="color:#bfe6df"><span class="leaf-bullet" style="background:#fff"></span> PRODUCT CATALOGUE</div>
    <h1>Our Products</h1>
    <div class="crumbs"><a href="{{ route('home') }}">Home</a> / Our Products</div>
  </div>
</div>

<div class="wrap">
  <div class="toolbar">
    <div class="search-row">
      <input id="searchInput" type="text" placeholder="Search by product name, salt or composition (e.g. Ketoconazole, Melfade, Cream)…" value="{{ request('q') }}">
      <button type="button" onclick="filterProducts()">Search</button>
    </div>
    <div class="cat-filters" id="catFilters">
      <div class="cat-chip{{ !request('cat') ? ' active' : '' }}" data-cat="all">All Products</div>
      @foreach($categories as $cat)
      <div class="cat-chip{{ request('cat') === $cat->slug ? ' active' : '' }}" data-cat="{{ $cat->slug }}">{{ $cat->name }}</div>
      @endforeach
    </div>
  </div>

  <section style="padding-top:0;">
    <div class="count-row">
      <span id="resultCount">Showing {{ $products->count() }} products</span>
      <span>Tip: filter by therapeutic area, or search by salt name</span>
    </div>

    <div class="product-grid" id="productGrid"></div>
    <div class="no-results" id="noResults">No products matched your search. Try a different keyword or clear the filters.</div>
  </section>
</div>

<section style="background:#fff;border-top:1px solid var(--border);margin-top:20px;">
  <div class="wrap" style="text-align:center;">
    <h2 style="font-size:24px;">Looking for full prescribing information?</h2>
    <p style="color:var(--muted);margin:12px 0 22px;">Healthcare professionals can request complete product monographs, packaging inserts and samples.</p>
    <a href="{{ route('home') }}#contact" class="btn btn-primary">Contact Our Medical Team →</a>
  </div>
</section>

@endsection

@push('scripts')
<script>
const products = @json($productsJson);
const catLabel = @json($catLabels);
let activeCat = {{ Illuminate\Support\Js::from(request('cat') ?: 'all') }};

function render(list){
  const grid = document.getElementById('productGrid');
  grid.innerHTML = "";
  document.getElementById('noResults').style.display = list.length ? "none" : "block";
  document.getElementById('resultCount').textContent = `Showing ${list.length} product${list.length!==1?'s':''}`;
  list.forEach((p)=>{
    const el = document.createElement('div');
    el.className = "pcard";
    el.innerHTML = `
      <div class="pcard-media" style="background:linear-gradient(135deg,${p.grad[0]},${p.grad[1]})">
        <span class="pcard-tag">${catLabel[p.cat]}</span>
        ${p.name}
      </div>
      <div class="pcard-body">
        <h4>${p.name}</h4>
        <div class="comp">${p.comp}</div>
        <span class="pack">Pack size: ${p.pack}</span>
      </div>
      <button class="pcard-toggle" onclick="toggleCard(this)">
        View composition & details
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
      </button>
      <div class="pcard-detail">
        <p>${p.detail}</p>
        <ul><li>Category: ${catLabel[p.cat]}</li><li>Pack size: ${p.pack}</li></ul>
      </div>`;
    grid.appendChild(el);
  });
}

function toggleCard(btn){
  btn.classList.toggle('open');
  btn.nextElementSibling.classList.toggle('open');
}

function filterProducts(){
  const q = document.getElementById('searchInput').value.toLowerCase().trim();
  let list = products.filter(p => activeCat==="all" || p.cat===activeCat);
  if(q){
    list = list.filter(p => p.name.toLowerCase().includes(q) || p.comp.toLowerCase().includes(q));
  }
  render(list);
}

document.querySelectorAll('.cat-chip').forEach(chip=>{
  chip.addEventListener('click', ()=>{
    document.querySelectorAll('.cat-chip').forEach(c=>c.classList.remove('active'));
    chip.classList.add('active');
    activeCat = chip.dataset.cat;
    filterProducts();
  });
});
document.getElementById('searchInput').addEventListener('input', filterProducts);

filterProducts();
</script>
@endpush
