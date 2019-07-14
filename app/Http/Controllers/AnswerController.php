<?php
namespace App\Http\Controllers;

use App\Answer as Answer;
use App\Question as Question;
use App\Respondent as Respondent;
use Validator;
use Illuminate\Http\Request;

class AnswerController extends Controller
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

    public function getById($id)
    {
        $answer = Answer::with('respondent')->with('questionOption.question')->where('id', $id)->first();
        return response()->json($answer, 201);
    }

    public function store(Answer $answer, $respondentId, $questionId)
    {

        if (!Respondent::find($respondentId) && !Question::find($questionId)) {
            return response()->json([
                'errors' => [
                    'details' => ['Respondent or Question is not found'],
                ],
                'code' => 422,
                'messages' => 'No Content'
            ], 422);
        }

        $answer = new Answer();

        $answer->question_option_id = $this->request->input('question_option_id');
        $answer->answer_numeric = $this->request->input('answer_numeric');
        $answer->answer_text = $this->request->input('answer_text');
        $answer->respondent_id = $respondentId;
        $answer->save();
        
        $answer = Answer::with('respondent')->with('questionOption.question')->where('id', $id)->first();
        return response()->json($answer, 201);
    }
}
