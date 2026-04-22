@extends('layouts.app')

@section('title', 'Login - Quiz')

@section('content')
<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Get Started</div>
            <h1 class="quiz-title">Sign In</h1>
        </div>
    </div>

    <div class="question-card">
        <form method="POST" class="auth-form">
            @csrf
            
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    id="email"
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="form-input"
                    placeholder="Enter your email"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input 
                    id="password"
                    type="password" 
                    name="password"
                    required
                    class="form-input"
                    placeholder="Enter your password"
                >
            </div>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 1.6rem;">
        <p class="quiz-label">Don't have an account? <a href="/register" style="color: var(--accent); text-decoration: none;">Register</a></p>
    </div>
</div>
@endsection