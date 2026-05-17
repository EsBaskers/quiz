@extends('layouts.app')

@section('title', 'Select Quiz - Lab Tit')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="/Main" class="btn btn-ghost" style="text-decoration: none;">← Sākums</a>
        <h1 class="quiz-title">Lab<span>tit</span></h1>
        <div class="navbar-controls">
            <a href="{{ route('leaderboard') }}" class="btn btn-ghost" style="text-decoration: none;">Leaderboard</a>
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
            <div class="profile-menu">
                <button class="profile-btn">
                    <span>{{ Auth::user()->name ?? 'Profile' }}</span>
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="4 6 8 10 12 6"></polyline>
                    </svg>
                </button>
                <div class="profile-dropdown">
                    <a href="/profile" class="dropdown-item">Mans profils</a>
                    <a href="/settings" class="dropdown-item">Profila iestatījumi</a>
                    <hr class="dropdown-divider">
                    <form action="/logout" method="GET" style="margin: 0;">
                        @csrf
                        <button type="submit" class="dropdown-item logout-item">Izlogoties</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    // Check for saved theme preference or default to light mode
    const currentTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', currentTheme);
    
    themeToggle.addEventListener('click', () => {
        const theme = html.getAttribute('data-theme');
        const newTheme = theme === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
</script>

<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Choose a Subject</div>
            <h1 class="quiz-title">Select <span>Quiz</span></h1>
        </div>
    </div>

    <div class="subjects-grid">
        @foreach($subjects as $subject)
            <a href="/quiz/{{ $subject->id }}" class="subject-card">
                <h3 class="subject-title">{{ $subject->name }}</h3>
                <p class="subject-description">{{ $subject->description }}</p>
                <span class="subject-count">{{ $subject->questions->count() }} Questions</span>
            </a>
        @endforeach
    </div>
</div>

<style>
    .subjects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.2rem;
        margin-bottom: 2rem;
    }

    .subject-card {
        display: block;
        padding: 1.6rem;
        background: var(--card);
        border: 1.5px solid var(--border);
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 4px 4px 0 var(--border);
    }

    .subject-card:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        box-shadow: 4px 6px 0 var(--border);
    }

    .subject-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--ink);
        margin-bottom: 0.6rem;
    }

    .subject-description {
        font-size: 0.85rem;
        color: var(--muted);
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .subject-count {
        display: inline-block;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 500;
    }
</style>
@endsection
