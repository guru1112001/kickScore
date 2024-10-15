<?php

namespace App\Http\Controllers;

use App\Models\QuestionBank;
use Illuminate\Http\Request;

class QuestionBankController extends Controller
{
    public function index()
    {
        $questionBanks = QuestionBank::all()->map(function ($questionBank) {
            $questionBank->image = $questionBank->image ? url("storage/" . $questionBank->image) : null;
            return $questionBank;
        });

        return $questionBanks;
    }

    public function getQuestionsForBank($questionBankId)
    {
        // Fetch the question bank with its questions and the associated options for each question
        $questionBank = QuestionBank::with('questions.options')->findOrFail($questionBankId);
        return $questionBank->questions;
    }
}
