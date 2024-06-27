@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">User Dashboard</h1>

    <form method="GET" action="{{ route('dashboard.index') }}" class="form-inline card mb-4 border-primary rounded">
        <div class="card-header">
            Search
        </div>
        <div class="card-body d-flex flex-column gap-2">
            <div class="d-flex">
                <div class="form-group flex-grow-1">
                    <input type="text" name="search" class="form-control mb-2" placeholder="Search by name or email" value="{{ request('search') }}">
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <div class="d-flex gap-2 align-items-center">
                    <div class="col-auto form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="0" id="roleUser" {{ in_array('0', request('roles', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="roleUser">User</label>
                    </div>
                    <div class="col-auto form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="1" id="roleAdmin" {{ in_array('1', request('roles', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="roleAdmin">Admin</label>
                    </div>
                    <div class="col-auto form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="2" id="roleOperator" {{ in_array('2', request('roles', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="roleOperator">Operator</label>
                    </div>
                    <div class="form-group">
                        <select name="sort_order" class="form-control">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>ID Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>ID Descending</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mr-2" style="width: 100px;">Search</button>
            </div>
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links('pagination::bootstrap-4') }}
</div>
@endsection