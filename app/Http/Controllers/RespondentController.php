<?php

namespace App\Http\Controllers;

use App\Respondent as Respondent;
use Validator;
use Illuminate\Http\Request;

class RespondentController extends Controller
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

    public function getAll(Respondent $respondent)
    {
        $respondent = new Respondent();

        return response()->json($respondent::all(), 200);
    }

    public function getById(Respondent $respondent, $id)
    {
        $respondent = new Respondent();
        $respondent = $respondent::where('id', $id)->first();

        if (!$respondent) {
            return response()->json([
                'errors'=> ['details' => 'Respondent is not found'],
                'code' => 400,
                'messages' => 'Bad Request'
            ], 400);
        }

        return response()->json($respondent, 200);
    }

    public function store(Respondent $respondent)
    {
        $this->validate($this->request, [
            'full_name' => 'required',
            'address' => 'required',
            'gender' => 'required'
        ]);
        
        $respondent = Respondent::create($this->request->all());
        // $respondent->full_name = $this->request->input('full_name');
        // $respondent->address = $this->request->input('address');
        // $respondent->gender = $this->request->input('gender');
        // $respondent->save();

        return response()->json($respondent, 400);
    }
    
}
