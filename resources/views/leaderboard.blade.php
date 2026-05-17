@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="/Main" class="btn btn-ghost" style="text-decoration: none;">← Sākums</a>
        <h1 class="quiz-title">Leaderboard</h1>
        <div class="navbar-controls">
            <a href="{{ route('leaderboard') }}" class="btn btn-primary" style="text-decoration: none;">Leaderboard</a>
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
    </div>
</nav>

<div class="quiz-wrapper leaderboard-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Visi lietotāji</div>
            <h1 class="quiz-title">Top rezultāti</h1>
        </div>
    </div>

    <div class="leaderboard-list">
        @foreach($leaders as $leader)
            <div class="leaderboard-row">
                <div class="leaderboard-rank">{{ $loop->iteration }}</div>
                <div class="leaderboard-user">
                    <strong>{{ $leader->name }}</strong>
                    <span>{{ $leader->email }}</span>
                </div>
                <div class="leaderboard-score">
                    <strong>{{ $leader->best_score }}%</strong>
                    <span>Best</span>
                </div>
                <div class="leaderboard-score">
                    <strong>{{ $leader->average_score }}%</strong>
                    <span>Average</span>
                </div>
                <div class="leaderboard-score">
                    <strong>{{ $leader->attempts }}</strong>
                    <span>Attempts</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
