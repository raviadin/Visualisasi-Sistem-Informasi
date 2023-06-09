@extends('layouts.app')
@section('title', 'Profile')
@section('content')

    <div class="container">
        <div class="col-12 mt-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center">Profile</h5>
                        </div>
                        <div class="card-body mx-4">
                            <div class="text-center">
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
                                    class="img-circle elevation-2" alt="User Image" style="width: 35px; margin-top:-10px;">
                            </div>
                            <div class="text-left mt-4">
                                <table>
                                    <tr>
                                        <th>Name</th>
                                        <th>:</th>
                                        <td>{{ Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <th>:</th>
                                        <td>{{ Auth::user()->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <th>:</th>
                                        <td>{{ Auth::user()->role }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center">Edit Profile</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateDataUser', Auth::user()->id) }}" method="post">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" class="form-control" required name="name"
                                        value="{{ Auth::user()->name }}" placeholder="Insert Your Name">
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="text" class="form-control" required name="email"
                                        value="{{ Auth::user()->email }}" placeholder="Insert Your Email">
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Insert Your New Password">
                                </div>
                                <div class="form-group">
                                    <label for="">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        placeholder="Confirm Your New Password">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-warning text-white">Update Data</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
