@extends('setup.layout', ['currentStep' => 4])

@section('title', 'Admin Account')

@section('content')
<h1>Create Your Admin Account</h1>
<p class="lead">This account will be used to sign in to the admin panel at <code>/admin</code> to manage products, categories, testimonials, job openings and applications.</p>

<form class="setup-form" method="POST" action="{{ route('setup.admin.create') }}">
  @csrf

  <label>Full Name</label>
  <input type="text" name="name" required value="{{ old('name') }}" placeholder="Your name">
  @error('name')<span class="field-error">{{ $message }}</span>@enderror

  <label>Email Address</label>
  <input type="email" name="email" required value="{{ old('email') }}" placeholder="you@rjspharma.in">
  @error('email')<span class="field-error">{{ $message }}</span>@enderror

  <div class="two-col">
    <div>
      <label>Password</label>
      <input type="password" name="password" required placeholder="At least 8 characters">
      @error('password')<span class="field-error">{{ $message }}</span>@enderror
    </div>
    <div>
      <label>Confirm Password</label>
      <input type="password" name="password_confirmation" required placeholder="Repeat password">
    </div>
  </div>

  <div class="setup-actions">
    <button type="submit" class="btn btn-primary">Create Account →</button>
  </div>
</form>
@endsection
