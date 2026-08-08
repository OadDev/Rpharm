@extends('setup.layout', ['currentStep' => 2])

@section('title', 'Database')

@section('content')
<h1>Connect Your Database</h1>
<p class="lead">Enter your database connection details. We'll test the connection before saving anything.</p>

<form class="setup-form" method="POST" action="{{ route('setup.database.save') }}" id="dbForm">
  @csrf

  <label>Database Type</label>
  <select name="driver" id="driverSelect">
    <option value="mysql" {{ old('driver', $current['driver']) === 'mysql' ? 'selected' : '' }}>MySQL / MariaDB</option>
    <option value="sqlite" {{ old('driver', $current['driver']) === 'sqlite' ? 'selected' : '' }}>SQLite (single file, good for testing)</option>
  </select>

  <div id="mysqlFields">
    <div class="two-col">
      <div>
        <label>Host</label>
        <input type="text" name="host" value="{{ old('host', $current['host']) }}" placeholder="127.0.0.1">
        @error('host')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div>
        <label>Port</label>
        <input type="text" name="port" value="{{ old('port', $current['port']) }}" placeholder="3306">
        @error('port')<span class="field-error">{{ $message }}</span>@enderror
      </div>
    </div>
    <label>Database Name</label>
    <input type="text" name="database" value="{{ old('database', $current['database']) }}" placeholder="rjs_pharma">
    @error('database')<span class="field-error">{{ $message }}</span>@enderror

    <div class="two-col">
      <div>
        <label>Username</label>
        <input type="text" name="username" value="{{ old('username', $current['username']) }}" placeholder="root">
        @error('username')<span class="field-error">{{ $message }}</span>@enderror
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••">
        @error('password')<span class="field-error">{{ $message }}</span>@enderror
      </div>
    </div>
  </div>

  <div class="setup-actions">
    <button type="submit" class="btn btn-primary">Test & Save Connection →</button>
  </div>
</form>

<script>
  const driverSelect = document.getElementById('driverSelect');
  const mysqlFields = document.getElementById('mysqlFields');
  function toggleFields(){
    mysqlFields.style.display = driverSelect.value === 'mysql' ? 'block' : 'none';
    mysqlFields.querySelectorAll('input').forEach(i => i.required = driverSelect.value === 'mysql');
  }
  driverSelect.addEventListener('change', toggleFields);
  toggleFields();
</script>
@endsection
