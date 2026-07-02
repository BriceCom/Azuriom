<?php

namespace Azuriom\Plugin\FAQ\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\FAQ\Models\Question;
use Azuriom\Plugin\FAQ\Requests\QuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::orderBy('position')->get();

        return view('faq::admin.questions.index', ['questions' => $questions]);
    }

    /**
     * Update the resources order in storage.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'questions' => ['required', 'array'],
        ]);

        $questions = $request->input('questions');

        $position = 1;

        foreach ($questions as $questionId) {
            Question::whereKey($questionId)->update(['position' => $position++]);
        }

        return response()->json([
            'message' => trans('faq::admin.questions.updated'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faq::admin.questions.create', [
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $question = Question::create($request->validated());

        $question->persistPendingAttachments($request->input('pending_id'));

        return to_route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        return view('faq::admin.questions.edit', ['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return to_route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return to_route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }
}
