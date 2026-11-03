
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="max-width: 450px; margin: 40px auto;">

    <h2>Hardware Inventory Login</h2>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf

        <div style="margin-bottom: 15px;">
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                style="width: 100%; padding: 10px;"
            >
        </div>

        <div style="margin-bottom: 15px;">
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
                style="width: 100%; padding: 10px;"
            >
        </div>

        <button type="submit">Login</button>
    </form>

</div>
@endsection
