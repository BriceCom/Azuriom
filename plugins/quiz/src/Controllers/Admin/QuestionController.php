<?php

namespace Azuriom\Plugin\Quiz\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Quiz\Models\Question;
use Azuriom\Plugin\Quiz\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{
    public function index()
    {
        return view('quiz::admin.questions.index', [
            'questions' => Question::withCount('responses')->latest('activation_date')->paginate(),
        ]);
    }

    public function create()
    {
        return view('quiz::admin.questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'reward' => ['required', 'integer', 'min:0'],
            'time_limit' => ['nullable', 'integer', 'min:1'],
            'activation_date' => ['required', 'date', 'unique:quiz_questions,activation_date'],
            'is_active' => ['boolean'],
            'answers' => ['required', 'array', 'min:2', 'max:4'],
            'answers.*' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $question = Question::create(Arr::except($validated, ['answers', 'correct_answer']));

        foreach ($validated['answers'] as $index => $answerText) {
            $question->answers()->create([
                'answer' => $answerText,
                'is_correct' => $index == $validated['correct_answer'],
            ]);
        }

        return redirect()->route('quiz.admin.questions.index')
            ->with('success', trans('quiz::admin.messages.created'));
    }

    public function edit(Question $question)
    {
        return view('quiz::admin.questions.edit', [
            'question' => $question->load('answers'),
        ]);
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'string', 'in:easy,medium,hard'],
            'reward' => ['required', 'integer', 'min:0'],
            'time_limit' => ['nullable', 'integer', 'min:1'],
            'activation_date' => ['required', 'date', 'unique:quiz_questions,activation_date,' . $question->id],
            'is_active' => ['boolean'],
            'answers' => ['required', 'array', 'min:2', 'max:4'],
            'answers.*' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $question->update(Arr::except($validated, ['answers', 'correct_answer']));

        $question->answers()->delete();

        foreach ($validated['answers'] as $index => $answerText) {
            $question->answers()->create([
                'answer' => $answerText,
                'is_correct' => $index == $validated['correct_answer'],
            ]);
        }

        return redirect()->route('quiz.admin.questions.index')
            ->with('success', trans('quiz::admin.messages.updated'));
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('quiz.admin.questions.index')
            ->with('success', trans('quiz::admin.messages.deleted'));
    }
}
