@extends('layouts.app')

@section('title', 'Welcome - Quiz')

@section('content')
<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">Welcome</div>
            <h1 class="quiz-title">Lab<span>tit</span></h1>
        </div>
    </div>

    @guest
        <div class="question-card">
            <p class="q-text" style="margin-bottom: 1.6rem;">Get started with our interactive quiz platform</p>
            <div class="actions">
                <a href="/login" class="btn btn-primary">Login</a>
                <a href="/register" class="btn btn-ghost">Register</a>
            </div>
        </div>
    @endguest

    @auth
        <div class="question-card">
            <p class="quiz-label">Your Account</p>
            <p class="q-text" style="margin-bottom: 1.6rem;">Welcome back, {{ Auth::user()->name }}!</p>
            
            <div class="actions">
                <a href="/quiz" class="btn btn-primary">Start Quiz</a>
                <a href="/logout" class="btn btn-ghost">Logout</a>
            </div>
        </div>
    @endauth
</div>
@endsection