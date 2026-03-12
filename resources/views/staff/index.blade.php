@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4">Staff Management</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    {{-- Create Staff Form --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4>Add Event Manager</h4>

            <form method="POST" action="{{ route('staff.store') }}">
                @csrf

                <div class="row">

                    <div class="col-md-3">
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="Name"
                               required>
                    </div>

                    <div class="col-md-3">
                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Email"
                               required>
                    </div>

                    <div class="col-md-3">
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Password"
                               required>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success">
                            Create Staff
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    {{-- Staff List --}}
    <div class="card">
        <div class="card-body">

            <h4>Staff List</h4>

            <table class="table table-bordered mt-3">

                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($staff as $member)

                    <tr>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->role }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3" class="text-center">
                            No Staff Found
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection