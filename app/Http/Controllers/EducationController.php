<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function getEducationRandom()
    {
        try {
            $educations = Education::inRandomOrder()->limit(4)->get();

            if ($educations->isEmpty()) {
                return response()->json(['error' => 'Education not found'], 404);
            }

            return response()->json($educations);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}