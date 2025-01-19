<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Education;

class EducationController extends Controller
{
    public function getEducationById($id)
    {
        try {
            $education = Education::find($id);

            if (!$education) {
                return response()->json(['error' => 'Education not found'], 404);
            }

            return response()->json($education);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

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

    public function getEducationList(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        try {
            $educations = Education::all();
            return response()->json($educations);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function updateEducation(Request $request, $id)
    {
        try {
            $education = Education::find($id);

            if (!$education) {
                return response()->json(['error' => 'Education not found'], 404);
            }

            $education->update($request->all());

            return response()->json(['message' => 'Success update']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function createEducation(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'required|string',
                'youtube' => 'required|string',
            ]);

            $education = Education::create($request->all());

            return response()->json($education, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function deleteEducation($id)
    {
        try {
            $education = Education::find($id);

            if (!$education) {
                return response()->json(['error' => 'Education not found'], 404);
            }

            $education->delete();

            return response()->json(['message' => 'Education deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}