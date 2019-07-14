<?php

namespace App\Http\Controllers;

use App\Respondent as Respondent;
use App\FamilyCard as FamilyCard;
use Validator;
use Illuminate\Http\Request;

class FamilyCardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function destroy(FamilyCard $familyCard, $id)
    {
        if (!FamilyCard::find($id)) {
            return response()->json([
                'errors' => [
                    'details' => ['Respondent is not found'],
                ],
                'code' => 422,
                'messages' => 'No Content'
            ], 422);
        }

        $familyCard = new FamilyCard();
        
        if ($familyCard::destroy($id)) return response()->json([], 204);
    }

    public function store(FamilyCard $familyCard, $id)
    {

        if (!Respondent::find($id)) {
            return response()->json([
                'errors' => [
                    'details' => ['Respondent is not found'],
                ],
                'code' => 422,
                'messages' => 'No Content'
            ], 422);
        }

        $familyCard = new FamilyCard();
        $familyCard->full_name = $this->request->input('full_name');
        $familyCard->status_of_intra_group_relation = $this->request->input('status_of_intra_group_relation');
        $familyCard->sex = $this->request->input('sex');
        $familyCard->age = $this->request->input('age');
        $familyCard->occupation = $this->request->input('occupation');
        $familyCard->respondent_id = $id;
        $familyCard->save();

        return response()->json($familyCard, 201);
    }
}
