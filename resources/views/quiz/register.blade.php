@extends('layouts.app')

@section('title', 'Register - Quiz')

@section('content')
<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Join Us</div>
            <h1 class="quiz-title">Create Account</h1>
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
                <label for="name" class="form-label">Username</label>
                <input 
                    id="name"
                    type="text"
                    name="name" 
                    required 
                    value="{{ old('name') }}"
                    class="form-input"
                    placeholder="Choose a username"
                >
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    id="email"
                    type="email" 
                    name="email" 
                    required 
                    value="{{ old('email') }}"
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
                    placeholder="Create a password"
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input 
                    id="password_confirmation"
                    type="password" 
                    name="password_confirmation"
                    required
                    class="form-input"
                    placeholder="Confirm your password"
                >
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 1.6rem;">
        <p class="quiz-label">Already have an account? <a href="/login" style="color: var(--accent); text-decoration: none;">Login</a></p>
    </div>
</div>
@endsection