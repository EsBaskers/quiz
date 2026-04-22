@extends('layouts.app')

@section('title', 'Settings - Lab Tit')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <h1 class="quiz-title">Lab<span>tit</span></h1>
        <div class="navbar-controls">
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
                <a href="/profile" class="dropdown-item">My Profile</a>
                <a href="/settings" class="dropdown-item">Account Settings</a>
                <hr class="dropdown-divider">
                <form action="/logout" method="GET" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item logout-item">Logout</button>
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
            <div class="quiz-label">Preferences</div>
            <h1 class="quiz-title" style="font-size: 2rem;">Account Settings</h1>
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

            <div style="margin-bottom: 2rem;">
                <div class="q-number">Account Settings</div>
                
                <div class="form-group" style="margin-top: 1rem;">
                    <label for="name" class="form-label">Username</label>
                    <input 
                        id="name"
                        type="text"
                        name="name" 
                        value="{{ Auth::user()->name }}"
                        class="form-input"
                        placeholder="Your username"
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input 
                        id="email"
                        type="email" 
                        name="email" 
                        value="{{ Auth::user()->email }}"
                        class="form-input"
                        placeholder="Your email"
                    >
                </div>
            </div>

            <div style="margin-bottom: 2rem;">
                <div class="q-number">Change Password</div>
                
                <div class="form-group" style="margin-top: 1rem;">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input 
                        id="current_password"
                        type="password" 
                        name="current_password"
                        class="form-input"
                        placeholder="Enter current password"
                    >
                </div>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input 
                        id="new_password"
                        type="password" 
                        name="new_password"
                        class="form-input"
                        placeholder="Enter new password"
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        id="password_confirmation"
                        type="password" 
                        name="password_confirmation"
                        class="form-input"
                        placeholder="Confirm new password"
                    >
                </div>
            </div>

            <div class="actions">
                <a href="/profile" class="btn btn-ghost">← Back</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
