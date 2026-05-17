@extends('layouts.app')

@section('title', 'Admin - Questions')

@section('content')
<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ route('admin.panel') }}" class="btn btn-ghost" style="text-decoration: none;">← Admin</a>
        <h1 class="quiz-title">Question Editor</h1>
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
            <h1 class="quiz-title">Edit questions</h1>
        </div>
    </div>

    <div class="admin-message" id="adminMessage" hidden></div>

    <div class="admin-question-list">
        @foreach($questions as $question)
            <form class="question-card admin-question-form" data-question-id="{{ $question->id }}">
                @csrf
                <div class="q-number">{{ $question->subject->name ?? 'No subject' }} / Question {{ $loop->iteration }}</div>

                <div class="form-group">
                    <label class="form-label" for="question-{{ $question->id }}">Question</label>
                    <input class="form-input" id="question-{{ $question->id }}" name="question" value="{{ $question->question }}" required>
                </div>

                <div class="admin-answer-grid">
                    @for($i = 1; $i <= 4; $i++)
                        <div class="form-group">
                            <label class="form-label" for="answer{{ $i }}-{{ $question->id }}">Answer {{ $i }}</label>
                            <input class="form-input" id="answer{{ $i }}-{{ $question->id }}" name="answer{{ $i }}" value="{{ optional($question->answers)->{'answer' . $i} }}" required>
                        </div>
                    @endfor
                </div>

                <div class="form-group">
                    <label class="form-label" for="correct-{{ $question->id }}">Correct answer</label>
                    <select class="form-input" id="correct-{{ $question->id }}" name="correct_answer" required>
                        @for($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}" @selected((int) $question->correct_answer === $i)>Answer {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="actions">
                    <span class="score-pill">ID: <strong>{{ $question->id }}</strong></span>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        @endforeach
    </div>
</div>

<script>
    const adminMessage = document.getElementById('adminMessage');

    function showAdminMessage(message, isError = false) {
        adminMessage.hidden = false;
        adminMessage.textContent = message;
        adminMessage.classList.toggle('error', isError);
    }

    document.querySelectorAll('.admin-question-form').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const questionId = form.dataset.questionId;
            const button = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);

            button.disabled = true;

            try {
                const response = await fetch(`/admin/questions/${questionId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': formData.get('_token'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    throw new Error('Could not save question.');
                }

                showAdminMessage('Question saved.');
            } catch (error) {
                showAdminMessage(error.message, true);
            } finally {
                button.disabled = false;
            }
        });
    });
</script>
@endsection
