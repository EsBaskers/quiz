@extends('layouts.app')

@section('title', 'Quiz - Lab Tit')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="btn btn-ghost" style="text-decoration: none;">← Home</a>
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
                <a href="/profile" class="dropdown-item" id="profileLink">Mans profils</a>
                <a href="/settings" class="dropdown-item" id="settingsLink">Profila iestatījumi</a>
                @if(Auth::user()?->isAdmin())
                    <a href="{{ route('admin.panel') }}" class="dropdown-item">Admin panel</a>
                @endif
                <hr class="dropdown-divider">
                <form action="/logout" method="GET" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item" id="logoutBtn">Izlogoties</button>
                </form>
            </div>
        </div>
        </div>
    </div>
</nav>

<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label" id="selectLabel">Choose your quiz</div>
            <h1 class="quiz-title" id="mainTitle">Izvēlieties savus izaicinājumus</h1>
        </div>
    </div>

    <div class="subjects-grid">
        @foreach($subjects as $subject)
            <a href="/quiz/{{ $subject->id }}" class="subject-card">
                <h3 class="card-title">{{ $subject->name }}</h3>
                <p class="card-desc">{{ $subject->description }}</p>
                <div class="card-meta">
                    <span class="question-count">{{ count($subject->questions) }} Jautājumi</span>
                </div>
            </a>
        @endforeach
    </div>
</div>

<style>
    .subjects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .subject-card {
        background: var(--card);
        border: 2px solid var(--border);
        border-radius: 12px;
        padding: 1.5rem;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .subject-card:hover {
        background: var(--accent);
        color: var(--paper);
        transform: translateY(-4px);
    }

    .card-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        margin: 0 0 0.5rem 0;
    }

    .card-desc {
        font-size: 0.95rem;
        margin: 0.5rem 0 1rem 0;
        opacity: 0.8;
    }

    .card-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .question-count {
        font-size: 0.85rem;
        opacity: 0.7;
    }

    .language-toggle {
        background: var(--card);
        border: 2px solid var(--border);
        color: var(--ink);
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        margin-right: 0.5rem;
    }

    .language-toggle:hover {
        background: var(--accent);
        color: var(--paper);
    }
</style>

<script>
    const html = document.documentElement;
    
    // Theme toggle only
    const themeToggle = document.getElementById('themeToggle');
    const currentTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', currentTheme);
    
    themeToggle.addEventListener('click', () => {
        const theme = html.getAttribute('data-theme');
        const newTheme = theme === 'light' ? 'dark' : 'light';
        html.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
</script>

@endsection
