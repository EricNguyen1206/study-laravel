@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <h1 class="mb-4">Edit User</h1>

  @if ($errors->any())
  <div class="alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  @if(session('success'))
  <div class="alert alert-success" id="success-alert">
    {{ session('success') }}
  </div>
  @endif

  <form method="POST" action="{{ route('dashboard.update', $user->id) }}">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>

    <div class="form-group">
      <label for="role">Role</label>
      <select class="form-control" id="role" name="role" required>
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="operator" {{ $user->role == 'operator' ? 'selected' : '' }}>Operator</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Save changes</button>
  </form>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Hide success alert after 5 seconds
    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
      setTimeout(() => {
        successAlert.style.display = 'none';
      }, 5000);
    }
  });
</script>
@endsection