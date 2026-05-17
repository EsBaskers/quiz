@extends('layouts.app')

@section('title', 'Login - Quiz')

@section('content')
    <div style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="/" class="btn btn-ghost" style="text-decoration: none; display: inline-flex; align-items: center;">← Sākums</a>
    </div>
    <div style="position: fixed; top: 1rem; right: 1rem; z-index: 1000;">
    <button class="theme-toggle" id="themeToggle" title="Toggle dark mode">
        <svg class="sun-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
        <svg class="moon-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    </button>
</div>

<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Sākt darbību</div>
            <h1 class="quiz-title">Pierakstīties</h1>
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
                <label for="email" class="form-label">E-pasts</label>
                <input 
                    id="email"
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="form-input"
                    placeholder="Ievadiet savu e-pastu"
                >
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Parole</label>
                <input 
                    id="password"
                    type="password" 
                    name="password"
                    required
                    class="form-input"
                    placeholder="Ievadiet savu paroli"
                >
            </div>

            <button type="submit" class="btn btn-primary">Pierakstīties</button>
        </form>
    </div>

    <div style="text-align: center; margin-top: 1.6rem;">
        <p class="quiz-label">Nav konta? <a href="/register" style="color: var(--accent); text-decoration: none;">Reģistrējieties</a></p>
    </div>
</div>
@endsection