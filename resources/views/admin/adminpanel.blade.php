@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="/Main" class="btn btn-ghost" style="text-decoration: none;">← Main</a>
        <h1 class="quiz-title">Admin Panel</h1>
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
        </div>
    </div>
</nav>

<div class="quiz-wrapper admin-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Admin only</div>
            <h1 class="quiz-title">Manage quizzes</h1>
        </div>
    </div>

    <div class="admin-stats">
        <div class="admin-stat">
            <span class="admin-stat-num">{{ $subjects->count() }}</span>
            <span class="admin-stat-label">Subjects</span>
        </div>
        <div class="admin-stat">
            <span class="admin-stat-num">{{ $questionsCount }}</span>
            <span class="admin-stat-label">Questions</span>
        </div>
        <div class="admin-stat">
            <span class="admin-stat-num">{{ $missingAnswersCount }}</span>
            <span class="admin-stat-label">Missing answers</span>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-message">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="admin-message error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="question-card">
        <div class="q-number">Admins</div>
        <h2 class="q-text">Add admin by email</h2>
        <p class="admin-copy">The email must belong to an existing registered user.</p>

        <form action="{{ route('admin.admins.store') }}" method="POST" class="admin-inline-form">
            @csrf
            <input class="form-input" type="email" name="email" placeholder="user@example.com" value="{{ old('email') }}" required>
            <button class="btn btn-primary" type="submit">Add admin</button>
        </form>

        <div class="admin-user-list">
            @foreach($admins as $admin)
                <div class="admin-user-row">
                    <span>{{ $admin->name }}</span>
                    <strong>{{ $admin->email }}</strong>
                </div>
            @endforeach
        </div>
    </div>

    <div class="question-card">
        <div class="q-number">Tools</div>
        <h2 class="q-text">Question editor</h2>
        <p class="admin-copy">Edit question text, answers, and the correct option for each quiz question.</p>
        <div class="actions admin-actions">
            <a href="{{ route('admin.questions') }}" class="btn btn-primary" style="text-decoration: none;">Open editor →</a>
        </div>
    </div>

    <div class="admin-subject-list">
        @foreach($subjects as $subject)
            <div class="admin-subject-row">
                <span>{{ $subject->name }}</span>
                <strong>{{ $subject->questions_count }} questions</strong>
            </div>
        @endforeach
    </div>
</div>
@endsection
