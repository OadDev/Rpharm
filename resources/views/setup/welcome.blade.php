@extends('setup.layout', ['currentStep' => 1])

@section('title', 'Welcome')

@section('content')
<h1>Welcome to RJS Pharma</h1>
<p class="lead">Let's get your site set up. First, we'll check that your server meets the requirements needed to run the application.</p>

<ul class="check-list">
  @foreach($checks as $check)
  <li class="{{ $check['passed'] ? 'pass' : 'fail' }}">
    <span class="check-icon">{{ $check['passed'] ? '✓' : '✕' }}</span>
    {{ $check['label'] }}
    <b>{{ $check['passed'] ? 'OK' : 'Missing' }}</b>
  </li>
  @endforeach
</ul>

@php($allPassed = collect($checks)->every(fn($c) => $c['passed']))

<form method="POST" action="{{ route('setup.welcome.proceed') }}">
  @csrf
  <div class="setup-actions">
    <button type="submit" class="btn btn-primary" {{ $allPassed ? '' : 'disabled' }}>Continue →</button>
  </div>
</form>
@if(!$allPassed)
<p class="setup-note">Resolve the failing checks above, then refresh this page to re-run them.</p>
@endif
@endsection
