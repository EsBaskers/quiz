<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use App\Models\QuizResult;
use App\Models\question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class QuizController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('questions')->get();
        return view('quiz-select', compact('subjects'));
    }

    public function show($subjectId)
    {
        $subject = Subject::findOrFail($subjectId);
        $questions = $subject->questions()->with('answers')->inRandomOrder()->get();

        $questions->each(function ($question) {
            if (!$question->answers) {
                return;
            }

            $options = collect([
                ['original' => 1, 'text' => $question->answers->answer1],
                ['original' => 2, 'text' => $question->answers->answer2],
                ['original' => 3, 'text' => $question->answers->answer3],
                ['original' => 4, 'text' => $question->answers->answer4],
            ])->shuffle()->values();

            $shuffledAnswers = $question->answers->replicate();
            $options->each(function ($option, $index) use ($shuffledAnswers) {
                $shuffledAnswers->{'answer' . ($index + 1)} = $option['text'];
            });

            $question->setRelation('answers', $shuffledAnswers);
            $question->correct_answer = $options->search(fn ($option) => $option['original'] === (int) $question->correct_answer) + 1;
        });

        return view('quiz-start', compact('subject', 'questions'));
    }

    public function adminPanel()
    {
        $this->authorizeAdmin();

        $subjects = Subject::withCount('questions')->get();
        $questionsCount = question::count();
        $missingAnswersCount = question::doesntHave('answers')->count();
        $admins = User::where('is_admin', true)->orderBy('name')->get();

        return view('admin.adminpanel', compact('subjects', 'questionsCount', 'missingAnswersCount', 'admins'));
    }

    public function leaderboard()
    {
        $leaders = User::query()
            ->leftJoin('quiz_results', 'users.id', '=', 'quiz_results.user_id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COALESCE(MAX(quiz_results.score), 0) as best_score'),
                DB::raw('COALESCE(ROUND(AVG(quiz_results.score)), 0) as average_score'),
                DB::raw('COUNT(quiz_results.id) as attempts')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderByDesc('best_score')
            ->orderByDesc('average_score')
            ->orderByDesc('attempts')
            ->get();

        return view('leaderboard', compact('leaders'));
    }

    public function storeResult(Request $request, $subjectId)
    {
        $subject = Subject::findOrFail($subjectId);

        $validated = $request->validate([
            'correct_answers' => ['required', 'integer', 'min:0'],
            'total_questions' => ['required', 'integer', 'min:1'],
            'score' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $correctAnswers = min($validated['correct_answers'], $validated['total_questions']);
        $score = (int) round(($correctAnswers / $validated['total_questions']) * 100);

        QuizResult::create([
            'user_id' => Auth::id(),
            'subject_id' => $subject->id,
            'correct_answers' => $correctAnswers,
            'total_questions' => $validated['total_questions'],
            'score' => $score,
        ]);

        return response()->json(['success' => true]);
    }

    public function addAdmin(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $validated['email'])->firstOrFail();
        $user->forceFill(['is_admin' => true])->save();

        return redirect()
            ->route('admin.panel')
            ->with('success', $user->email . ' is now an admin.');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        // Only validate passwords if they're being changed
        if ($request->filled('new_password')) {
            $passwordValidated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'string', Password::min(6)->numbers()->letters()->symbols()],
                'password_confirmation' => ['required', 'same:new_password'],
            ]);
            $validated = array_merge($validated, $passwordValidated);
        }

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($request->filled('new_password')) {
            $user->update(['password' => bcrypt($validated['new_password'])]);
        }

        return redirect('/settings')->with('success', 'Settings updated successfully!');
    }

    public function editQuestions()
    {
        $this->authorizeAdmin();

        $questions = question::with('answers', 'subject')->get();
        $subjects = Subject::all();
        return view('admin.questions', compact('questions', 'subjects'));
    }

    public function updateQuestion(Request $request, $questionId)
    {
        $this->authorizeAdmin();

        $question = question::findOrFail($questionId);
        
        $validated = $request->validate([
            'question' => 'required|string',
            'answer1' => 'required|string',
            'answer2' => 'required|string',
            'answer3' => 'required|string',
            'answer4' => 'required|string',
            'correct_answer' => 'required|in:1,2,3,4'
        ]);

        $question->update([
            'question' => $validated['question'],
            'correct_answer' => $validated['correct_answer']
        ]);

        $question->answers()->delete();
        $question->answers()->create([
            'answer1' => $validated['answer1'],
            'answer2' => $validated['answer2'],
            'answer3' => $validated['answer3'],
            'answer4' => $validated['answer4']
        ]);

        return response()->json(['success' => true, 'message' => 'Question updated successfully!']);
    }

    private function authorizeAdmin(): void
    {
        abort_unless(Auth::user()?->isAdmin(), 403);
    }
}
