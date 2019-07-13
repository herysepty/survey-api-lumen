<?php

namespace App\Http\Controllers;

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
    public function __construct()
    {
        $this->request = $request;
    }

    public function store(Question $question)
    {
        
    }
}
