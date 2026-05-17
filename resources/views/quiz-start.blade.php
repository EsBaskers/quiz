@extends('layouts.app')

@section('title', $subject->name . ' - Quiz')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="/Main" class="btn btn-ghost" style="text-decoration: none;">← Sākums</a>
        <h1 class="quiz-title">{{ $subject->name }}</h1>
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

<div class="quiz-wrapper">
    <div class="quiz-header">
        <div>
            <div class="quiz-label">{{ $subject->name }}</div>
            <h1 class="quiz-title">Quiz Time</h1>
        </div>
        <div class="progress-ring">
            <svg width="64" height="64" viewBox="0 0 64 64">
                <circle class="ring-bg" cx="32" cy="32" r="26"></circle>
                <circle class="ring-fill" cx="32" cy="32" r="26"></circle>
            </svg>
            <div class="progress-num">0/{{ count($questions) }}</div>
        </div>
    </div>

    @if(count($questions) > 0)
        <div class="question-card">
            <div class="q-number">Question 1</div>
            <h2 class="q-text">{{ $questions[0]->question }}</h2>
        </div>

        <div class="options-grid">
            @php
                $answers = $questions[0]->answers;
                $options = ['answer1', 'answer2', 'answer3', 'answer4'];
                $labels = ['A', 'B', 'C', 'D'];
            @endphp

            @foreach($options as $index => $option)
                <button class="option" type="button" data-value="{{ $index + 1 }}" aria-pressed="false">
                    <div class="option-key">{{ $labels[$index] }}</div>
                    <div class="option-text">{{ optional($answers)->$option ?? 'N/A' }}</div>
                </button>
            @endforeach
        </div>

        <div class="actions">
            <button class="btn btn-ghost" id="prevBtn" disabled>← Iepriekšējais</button>
            <span class="score-pill">Atbildēts: <strong id="scoreText">0</strong></span>
            <button class="btn btn-primary" id="nextBtn" disabled>Nākamais →</button>
        </div>
    @else
        <div class="question-card">
            <p class="q-text">No questions available for this quiz yet.</p>
        </div>
        <div class="actions">
            <a href="/Main" class="btn btn-primary">← Back to Quizzes</a>
        </div>
    @endif
</div>

<script>
    (() => {
        const questions = @json($questions);
        const saveResultUrl = @json(route('quiz.results.store', $subject));
        const csrfToken = @json(csrf_token());

        if (!questions.length) {
            return;
        }

        const selectedAnswers = Array(questions.length).fill(null);
        let currentQuestion = 0;

        const optionButtons = document.querySelectorAll('.option');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const progressNum = document.querySelector('.progress-num');
        const ringFill = document.querySelector('.ring-fill');
        const quizHeader = document.querySelector('.quiz-header');
        const questionNumber = document.querySelector('.q-number');
        const questionText = document.querySelector('.q-text');
        const scoreText = document.getElementById('scoreText');
        const ringLength = 163;

        function answeredCount() {
            return selectedAnswers.filter(answer => answer !== null).length;
        }

        function updateProgress() {
            const answered = answeredCount();
            const percentage = (answered / questions.length) * 100;

            progressNum.textContent = `${answered}/${questions.length}`;
            ringFill.style.strokeDasharray = `${(percentage / 100) * ringLength} ${ringLength}`;
            quizHeader.style.setProperty('--progress-width', `${percentage}%`);
            scoreText.textContent = answered;
        }

        function updateUI() {
            const question = questions[currentQuestion];
            const savedAnswer = selectedAnswers[currentQuestion];
            const answerTexts = [
                question.answers?.answer1 ?? 'N/A',
                question.answers?.answer2 ?? 'N/A',
                question.answers?.answer3 ?? 'N/A',
                question.answers?.answer4 ?? 'N/A',
            ];

            questionNumber.textContent = `Question ${currentQuestion + 1}`;
            questionText.textContent = question.question;

            optionButtons.forEach((option, index) => {
                const value = index + 1;
                option.dataset.value = value;
                option.querySelector('.option-text').textContent = answerTexts[index];
                option.classList.toggle('selected', savedAnswer === value);
                option.setAttribute('aria-pressed', savedAnswer === value ? 'true' : 'false');
            });

            prevBtn.disabled = currentQuestion === 0;
            nextBtn.disabled = savedAnswer === null;
            nextBtn.textContent = currentQuestion === questions.length - 1 ? 'Finish →' : 'Nākamais →';
            updateProgress();
        }

        optionButtons.forEach(option => {
            option.addEventListener('click', () => {
                selectedAnswers[currentQuestion] = Number(option.dataset.value);
                updateUI();
            });
        });

        prevBtn.addEventListener('click', () => {
            if (currentQuestion > 0) {
                currentQuestion--;
                updateUI();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (selectedAnswers[currentQuestion] === null) {
                return;
            }

            if (currentQuestion < questions.length - 1) {
                currentQuestion++;
                updateUI();
                return;
            }

            submitQuiz();
        });

        function submitQuiz() {
            const correctAnswers = questions.reduce((total, question, index) => {
                return total + (selectedAnswers[index] === Number(question.correct_answer) ? 1 : 0);
            }, 0);
            const score = Math.round((correctAnswers / questions.length) * 100);

            saveResult(correctAnswers, questions.length, score);
            showResults(correctAnswers, questions.length, score);
        }

        async function saveResult(correctAnswers, totalQuestions, score) {
            try {
                await fetch(saveResultUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        correct_answers: correctAnswers,
                        total_questions: totalQuestions,
                        score,
                    }),
                });
            } catch (error) {
                console.error('Could not save quiz result.', error);
            }
        }

        function showResults(correct, total, percentage) {
            document.querySelector('.quiz-wrapper').innerHTML = `
                <div class="quiz-results">
                    <div class="results-card">
                        <h2>Viktorīna pabeigta!</h2>
                        <div class="result-score">
                            <div class="big-score">${percentage}%</div>
                            <div class="result-text">Jūs atbildējāt pareizi uz ${correct} no ${total} jautājumiem</div>
                        </div>
                        <div class="result-actions">
                            <a href="/Main" class="btn btn-primary">Atpakaļ uz viktorīnām</a>
                            <a href="/leaderboard" class="btn btn-ghost">Leaderboard</a>
                            <button onclick="location.reload()" class="btn btn-ghost">Atkārtot viktorīnu</button>
                        </div>
                    </div>
                </div>
            `;
        }

        updateUI();
    })();
</script>
@endsection
