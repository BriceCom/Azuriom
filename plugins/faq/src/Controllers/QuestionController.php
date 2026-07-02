<?php

namespace Azuriom\Plugin\FAQ\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\FAQ\Models\Question;

class QuestionController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index()
    {
        $questions = Question::orderBy('position')->get();

        return view('faq::index', ['questions' => $questions]);
    }
}
