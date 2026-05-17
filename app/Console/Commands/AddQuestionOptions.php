<?php

namespace App\Console\Commands;

use App\Models\Question;
use App\Models\answers;
use Illuminate\Console\Command;

class AddQuestionOptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quiz:add-options';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interactively add answer options for quiz questions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $questions = Question::all();
        
        $this->info('Adding answer options for ' . count($questions) . ' questions');
        $this->line('');

        foreach ($questions as $index => $question) {
            $this->line("Question " . ($index + 1) . ": {$question->question}");
            $this->line('(Enter the 4 answer options)');
            
            $answer1 = $this->ask('Option A');
            $answer2 = $this->ask('Option B');
            $answer3 = $this->ask('Option C');
            $answer4 = $this->ask('Option D');
            
            // Show the options and ask which is correct
            $this->line('');
            $this->info('Your options:');
            $this->line('1. ' . $answer1);
            $this->line('2. ' . $answer2);
            $this->line('3. ' . $answer3);
            $this->line('4. ' . $answer4);
            
            $correct = $this->choice('Which is the correct answer?', [
                '1. ' . $answer1,
                '2. ' . $answer2,
                '3. ' . $answer3,
                '4. ' . $answer4
            ]);
            
            $correctIndex = intval(explode('.', $correct)[0]);
            
            // Update or create answers
            answers::where('question_id', $question->id)->delete();
            answers::create([
                'question_id' => $question->id,
                'answer1' => $answer1,
                'answer2' => $answer2,
                'answer3' => $answer3,
                'answer4' => $answer4
            ]);
            
            // Update the correct answer on the question
            $question->update(['correct_answer' => $correctIndex]);
            
            $this->info('✓ Question saved!');
            $this->line('');
        }
        
        $this->info('All questions have been updated with options!');
    }
}
