<?php

namespace App\Http\Controllers;

use App\Question as Question;
use App\Answer as Answer;
use Validator;
use Illuminate\Http\Request;

class QuestionController extends Controller
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

    public function getAll()
    {
        // $employee = Employee::select(['idk as employee_id', 'nama as name', 'id_karyawan as employee_c'])->limit(100)->get();
        // if ($employee) {
        //     $this->employee = $employee;
        // } else {
        //     $this->employee = array(['error' => '401']);
        // }
        // return response($this->employee)->header('Content-Type', 'application/json');
    }

    public function store(Question $question)
    {
        $this->validate($this->request, [
            'question' => 'required',
            'description' => 'required'
        ]);
        
        $question = new Question();
        $question->question = $this->request->input('question');
        $question->description = $this->request->input('description');
        $question->save();

        $options = $this->request->input('options');
        
        if ($options) {
            foreach ($options as $option) {
                $answer = new Answer();
                $answer->description = $option['description'];
                $answer->question_id = $question->id;
                $answer->save();
            }
        }

        // return response(['status' => 200])
        //     ->header('Authorization','Bearer '.$this->jwt($user))
        //     ->header('Domain','Gadjian');

        return response()->json([
            'data' => $question
        ], 400);
    }
    
}
