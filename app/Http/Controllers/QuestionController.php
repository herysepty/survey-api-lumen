<?php

namespace App\Http\Controllers;

use App\Question as Question;
use App\OptionChoice as OptionChoice;
use App\QuestionOption as QuestionOption;
use App\OptionGroup as OptionGroup;
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
        $resultDataMap = [];
        // $employee = Employee::select(['idk as employee_id', 'nama as name', 'id_karyawan as employee_c'])->limit(100)->get();
        // if ($employee) {
        //     $this->employee = $employee;
        // } else {
        //     $this->employee = array(['error' => '401']);
        // }
        // return response($this->employee)->header('Content-Type', 'application/json');

        $Question = new Question();

        $questions = $Question::all();
        // var_dump($questions);

        foreach ($questions as $question) {
            $resultDataMapTmp = [];
            $OptionChoice = new OptionChoice();
            $OptionChoice = $OptionChoice::where('question_id', $question->id)->first();
            $resultDataMapTmp['option_choices'] = $OptionChoice;
        }


        return response()->json([
            'data' => $resultDataMapTmp
        ], 201);
    }

    public function store(Question $question)
    {
        $this->validate($this->request, [
            'question_name' => 'required',
            'question_subtext' => 'required',
            'input_type_name' => 'required',
            'option_choices' => 'required'
        ]);
        
        $question = new Question();
        $question->question_name = $this->request->input('question_name');
        $question->question_subtext = $this->request->input('question_subtext');
        $question->input_type_name = $this->request->input('input_type_name');
        $question->save();

        $OptionGroup = new OptionGroup();
        $optionGroup = $OptionGroup::where('option_group_code', $this->request->option_group['option_group_code'])->first();

        if (!$optionGroup) {
            $OptionGroup->option_group_code = $this->request->option_group['option_group_code'];
            $OptionGroup->option_group_name = $this->request->option_group['option_group_name'];
            $OptionGroup->save();
            $optionGroup = $OptionGroup;
        }

        $optionChoices = $this->request->input('option_choices');
        if ($optionChoices) {
            foreach ($optionChoices as $optionChoice) {
                $OptionChoice = new OptionChoice();
                $OptionChoice->option_choice_name = $optionChoice['option_choice_name'];
                $OptionChoice->option_group_id = $optionGroup->id;
                $OptionChoice->save();

                if (!empty($question->id) && !empty($OptionChoice->id)) {
                    $QuestionOption = new QuestionOption();
                    $QuestionOption->question_id = $question->id;
                    $QuestionOption->option_choice_id = $OptionChoice->id;
                    $QuestionOption->save();
                }
            }
        }

        // return response(['status' => 200])
        //     ->header('Authorization','Bearer '.$this->jwt($user))
        //     ->header('Domain','Gadjian');

        return response()->json([
            'data' => $question
        ], 201);
    }
    
}
