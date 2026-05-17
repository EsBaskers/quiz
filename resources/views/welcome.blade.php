@extends('layouts.app')

@section('title', 'Welcome - Quiz')

@section('content')
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
            <div class="quiz-label">Sveiki</div>
            <h1 class="quiz-title">Lab<span>tit</span></h1>
        </div>
    </div>

    @guest
        <div class="question-card">
            <p class="q-text" style="margin-bottom: 1.6rem;">Sāciet ar mūsu interaktīvo viktorīnu platformu</p>
            <div class="actions">
                <a href="/login" class="btn btn-primary">Pierakstīties</a>
                <a href="/register" class="btn btn-ghost">Reģistrēties</a>
            </div>
        </div>
    @endguest

    @auth
        <div class="question-card">
            <p class="quiz-label">Jūsu konts</p>
            <p class="q-text" style="margin-bottom: 1.6rem;">Laipni lūgti atpakaļ, {{ Auth::user()->name }}!</p>
            
            <div class="actions">
                <a href="/Main" class="btn btn-primary">Sākt viktorīnu</a>
                <a href="/logout" class="btn btn-ghost">Izlogoties</a>
            </div>
        </div>
    @endauth
</div>
@endsection