<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Models\question;
use App\Models\answers;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // IPB24 Subject
        $ipb24 = Subject::create([
            'name' => 'ipb24',
            'description' => 'Jautājumi par ipb24 klasi'
        ]);

        $ipb24_questions = [
            'Kurš ir lielākais gailis?',
            'Kurš ir lielākais gurķis?',
            'Kurš ir biggest sweat?',
            'Kurš varēja apēst arī ledusskapi?(Those who know)',
            'What is Pēteris?',
            'What does Niks do in his free time?',
            'Vai ernestam telefons raud?',
            'Who is the most jolly?',
            'Cik mēs bijām pirmā kursa sākumā?',
            'Kāda bija Dudareva un Meldera iesauka?',
            'Kurš bija gandrīz akls no mūsu klases?',
            'Most hardworking in class?',
            'Most athletic in class?',
            'Least braincells in class?',
            'Biggest brain in class?',
        ];

        foreach ($ipb24_questions as $q) {
            $question = $ipb24->questions()->create(['question' => $q, 'correct_answer' => 1]);
            $question->answers()->create(['answer1' => 'Option 1', 'answer2' => 'Option 2', 'answer3' => 'Option 3', 'answer4' => 'Option 4']);
        }

        // koju dzīve Subject
        $koju = Subject::create([
            'name' => 'koju dzīve',
            'description' => 'Jautājumi par dzīvi kojās'
        ]);

        $koju_questions = [
            'Minimālais vecums lai tu netiktu diddyed',
            'Cik maksā Saules ielas kojas?',
            'Kas ir koju staple foods?',
            'Kas notika Priekuļos ar podu(Baškera istabiņai)?',
            'Vai ir kārtība?',
            'Cik liela iespēja tikt čamdītam?',
            'Whos the biggest enemy to the tenants?',
            'Cik ilgi vari izdzīvot ar tikai roltoniem?',
            'Kuram kursam nepatīk duša?',
            'Kas notiek koju tualetēs?',
            'Kāda iespēja ieraudzīt kluci podā?',
            'Kāds ir ideālais "koju starter pack"?',
            'Cik tualetes durvis ir nozagtas no kojām?',
            'Vai ir droši izmantot koju tualete pie peak stundām',
            'Vai ir droši izmantot koju tualete pie peak stundām',
        ];

        foreach ($koju_questions as $q) {
            $question = $koju->questions()->create(['question' => $q, 'correct_answer' => 1]);
            $question->answers()->create(['answer1' => 'Option 1', 'answer2' => 'Option 2', 'answer3' => 'Option 3', 'answer4' => 'Option 4']);
        }

        // Stipendijas Subject
        $stipendijas = Subject::create([
            'name' => 'Stipendijas',
            'description' => 'Jautājumi par stipendijām'
        ]);

        $stipendijas_questions = [
            'Kur palika?',
            'Kāpēc Patrikam ir tik liela stipendija un man ir tik maza?',
            'Cik negatīvās, lai zaudētu stipendiju?',
            'Vai man būs liela stīpa?',
            'Kā var dabūt mega stīpu?',
            'Lielāka stīpa ko var iegūt',
            'Minimālā stipendija',
            'Kuram ir vismazākā stipendija (ipb24)?',
            'Prognozes manai stipendijai',
            'Avg stīpa',
            'Cik ātri pazūd tava stīpa?',
            'Vai mums nepieciešams palielināt stīpas?',
            'Kuram ir lielāka stipendija (miks v patriks)',
            'Vai niks var dabūt vairāk pa 15 eiro stipendijā?',
            'Reakcija uz stipendijas ienākšanas',
        ];

        foreach ($stipendijas_questions as $q) {
            $question = $stipendijas->questions()->create(['question' => $q, 'correct_answer' => 1]);
            $question->answers()->create(['answer1' => 'Option 1', 'answer2' => 'Option 2', 'answer3' => 'Option 3', 'answer4' => 'Option 4']);
        }

        // Maksimas piedzīvojumi Subject
        $maksima = Subject::create([
            'name' => 'Maksimas piedzīvojumi',
            'description' => 'Jautājumi par Maksimas kafejnīcu'
        ]);

        $maksima_questions = [
            'Cik maksā piciņa?',
            'Cik limpo zigmars izder dienā?',
            'Minimālais daudzums maksimas piciņām',
            'Vai tehnikuma students vispār eksistē bez Maksimas piciņas rokā?',
            'Cik enerģijas dzērienu vajag pirms pirmās stundas?',
            'Kāpēc visi "ātri aiziet uz Maksimu", bet atgriežas pēc stundas sākuma?',
            'Cik cilvēki vienlaikus stāv pie mikrenes ar vienu piciņu?',
            'Cik reižu dienā tehnikuma students pasaka: "Aizskrienam līdz Maksimai"?',
            'Kāpēc Maksima ir populārāka par bibliotēku?',
            'Cik ilgi var dzīvot tikai no piciņām?',
            'Vai iespējams ieiet Maksimā un ne satikt vismaz 10 pazīstamos?',
            'Kāpēc tieši starpbrīdī rindas kļūst garākas?',
            'Kad maksimā ir atlaides taviem produktiem?',
            'Kas visbiežāk pazūd pēc Maksimas pauzes?',
            'Ko nozīmē ātri līdz Maksimai?',
        ];

        $maksima_answers = [
            13 => ['correct' => 2, 'answers' => ['Nauda', 'Laiks', 'Mugursoma', 'Telefons']],
            14 => ['correct' => 3, 'answers' => ['5 minūtes', 'Viena stunda', 'Viss starpbrīdis', 'Nekad neatgriezties']],
        ];

        foreach ($maksima_questions as $index => $q) {
            $data = $maksima_answers[$index] ?? ['correct' => 1, 'answers' => ['Option 1', 'Option 2', 'Option 3', 'Option 4']];
            $question = $maksima->questions()->create(['question' => $q, 'correct_answer' => $data['correct']]);
            $question->answers()->create([
                'answer1' => $data['answers'][0],
                'answer2' => $data['answers'][1],
                'answer3' => $data['answers'][2],
                'answer4' => $data['answers'][3],
            ]);
        }

        // Programmēšana Subject
        $programming = Subject::create([
            'name' => 'Programmēšana',
            'description' => 'Jautājumi par programmēšanu'
        ]);

        $programming_questions = [
            'HTML pilnais nosaukums',
            'Kas nav programmēšanas valoda',
            'CSS saīsinājums',
            '5 + \'3\' JavaScript',
            'Komentārs Python',
            'Ko nozīmē "bug"',
            'print() funkcija',
            'Mainīgais JavaScript',
            'Kas ir "loop"',
            'Ko JavaScript salīdzina ar == operatoru?',
            'Masīva pirmā indeksa numurs',
            'Python izveides gads',
            'Ko nozīmē PHP saīsinājums?',
            'Kā PHP izveido mainīgo?',
            'Kurš simbols PHP rindas beigās parasti ir vajadzīgs?',
        ];

        $programming_answers = [
            ['correct' => 1, 'answers' => ['HyperText Markup Language', 'How to make lasagna', 'How track me live', 'Humans that might lie']],
            ['correct' => 2, 'answers' => ['JavaScript', 'HTML', 'Java', 'Python']],
            ['correct' => 2, 'answers' => ['Cool cooling stuff', 'Cascading Style Sheets', 'Compiler stinks stinky', 'Cambodian Sewing Stage']],
            ['correct' => 1, 'answers' => ['"53"', '8', 'error', 'JavaScript kaboom']],
            ['correct' => 1, 'answers' => ['# komentārs', '// komentārs', 'HTML komentārs', 'CSS komentārs']],
            ['correct' => 2, 'answers' => ['Programmas funkcija', 'Kļūda kodā', 'Datu tips', 'HTML tags']],
            ['correct' => 3, 'answers' => ['Dzēš tekstu', 'Izveido mainīgo', 'Izvada tekstu ekrānā', 'Aptur programmu']],
            ['correct' => 1, 'answers' => ['let name = Anna;', 'variable name Anna', 'var Anna', 'name := Anna']],
            ['correct' => 2, 'answers' => ['Vienreizējs nosacījums', 'Atkārtota darbība', 'Attēla formāts', 'Datubāzes tabula']],
            ['correct' => 2, 'answers' => ['Tikai tipu', 'Vērtību ar tipa pārveidošanu', 'Vienmēr objektus', 'Tikai garumu']],
            ['correct' => 1, 'answers' => ['0', '1', '-1', '10']],
            ['correct' => 3, 'answers' => ['1989', '1995', '1991', '2001']],
            ['correct' => 1, 'answers' => ['PHP: Hypertext Preprocessor', 'Private Hosting Platform', 'Program HTML Parser', 'Public HTTP Protocol']],
            ['correct' => 1, 'answers' => ['$name = Anna;', 'let $name = Anna;', 'name := Anna', 'php name Anna']],
            ['correct' => 3, 'answers' => ['Komats (,)', 'Punkts (.)', 'Semikols (;)', 'Kols (:)']],
        ];

        foreach ($programming_questions as $index => $q) {
            $data = $programming_answers[$index];
            $question = $programming->questions()->create(['question' => $q, 'correct_answer' => $data['correct']]);
            $question->answers()->create([
                'answer1' => $data['answers'][0],
                'answer2' => $data['answers'][1],
                'answer3' => $data['answers'][2],
                'answer4' => $data['answers'][3],
            ]);
        }
    }
}
