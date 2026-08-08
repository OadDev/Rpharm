@extends('setup.layout', ['currentStep' => 3])

@section('title', 'Install')

@section('content')
<h1>Install the Database</h1>
<p class="lead">This will create all required tables and load the RJS Pharma starter content (products, categories, therapeutic areas, job openings and more).</p>

@if($ran)
  <div class="setup-alert success">Installation completed successfully.</div>
  <div class="install-log">{{ $ran }}</div>
  <form method="GET" action="{{ route('setup.admin') }}">
    <div class="setup-actions">
      <button type="submit" class="btn btn-primary">Continue →</button>
    </div>
  </form>
@else
  <form method="POST" action="{{ route('setup.install.run') }}">
    @csrf
    <div class="setup-actions">
      <button type="submit" class="btn btn-primary">Run Installation →</button>
    </div>
  </form>
  <p class="setup-note">This runs database migrations and seeds starter content. It's safe to run more than once.</p>
@endif
@endsection
