<?php

namespace App\Http\Controllers;

use App\Question as Question;
use App\Respondent as Respondent;
use App\Answer as Answer;
use App\Survey as Survey;
use Validator;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    private $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function store(Question $question)
    {
        $this->validate($this->request, [
            'answer_id' => 'required',
            'question_id' => 'required',
            'respondent_id' => 'required'
        ]);

        $questionId = $this->request->input('question_id');
        $answerId = $this->request->input('answer_id');
        $respondentId = $this->request->input('respondent_id');
        
        $question = new Question();
        if (!$question::where('id', $questionId)->first()) {
            return response()->json([
                'errors'=> ['details' => 'Question is not found'],
                'code' => 400,
                'messages' => 'Bad Request'
            ], 400);
        }

        $answer = new Answer();
        if (!$answer::where('id', $answerId)->first()) {
            return response()->json([
                'errors'=> ['details' => 'Answer is not found'],
                'code' => 400,
                'messages' => 'Bad Request'
            ], 400);
        }

        $respondent = new Respondent();
        if (!$respondent::where('id', $respondentId)->first()) {
            return response()->json([
                'errors'=> ['details' => 'Respondent is not found'],
                'code' => 400,
                'messages' => 'Bad Request'
            ], 400);
        }

        
        $survey = new Survey();
        $survey->question_id = $this->request->input('question_id');
        $survey->answer_id = $this->request->input('answer_id');
        $survey->respondent_id = $this->request->input('respondent_id');
        $survey->save();

        return response()->json($survey, 400);
    }
    
}
