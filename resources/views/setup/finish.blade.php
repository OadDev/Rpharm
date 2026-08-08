@extends('setup.layout', ['currentStep' => 5])

@section('title', 'All Done')

@section('content')
<div class="setup-finish">
  <div class="icon">✓</div>
  <h1>You're All Set!</h1>
  <p class="lead">RJS Pharma is installed and ready to go. You can now visit your site or sign in to the admin panel to manage content.</p>

  <div class="setup-actions" style="justify-content:center;">
    <a href="{{ route('home') }}" class="btn btn-outline">View Site</a>
    <a href="/admin" class="btn btn-primary">Go to Admin Panel →</a>
  </div>

  <p class="setup-note">To re-run this wizard later, delete <code>storage/app/installed.flag</code> from the server.</p>
</div>
@endsection
