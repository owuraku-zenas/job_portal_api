<?php

namespace App\Http\Controllers;


use App\Models\Resume;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $resumes = Resume::all();

            $response = [
                'success' => true,
                'data' => $resumes,
                'message' => "Jobs retrieved successfully"
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error->getMessage(),
                'message' => "Falied to retrieve jobs"
            ], 500);
        }
    }

    public function user_resumes()
    {
        try {

            $resumes = Resume::where("company_id", Auth::user()->id)->get();

            $response = [
                'success' => true,
                'data' => $resumes,
                'message' => "Jobs retrieved successfully"
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {

            return response()->json([
                'success' => false,
                'data' => $error->getMessage(),
                'message' => "Falied to retrieve jobs"
            ], 500);
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'about' => 'required|string|max:255',
                'rate' => 'required|string',
                'job_title' => 'required|string',
                'tags' => 'required|array',
                'educations' => 'required|array',
                'personal_projects' => 'array',
                'job_experiences' => 'array',
                'website' => 'string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => $validator->errors()->all()
                ], 422);
            }

            $resume = "";

            $resume = Resume::create([
                'about' => $request->about,
                'email' => $request->user()->email,
                'rate' => $request->rate,
                'job_title' => $request->job_title,
                'tags' => json_encode($request->tags),
                'educations' => json_encode($request->educations),
                'personal_projects' => json_encode($request->personal_projects),
                'job_experiences' => json_encode($request->job_experiences),
                'website' => $request->website,
                'user_id' => $request->user()->id,
            ]);

            return response()->json([
                'success' => true,
                'data' => $resume,
                'message' => "Resume created successfully"
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error->getMessage(),
                'message' => "Falied to create resume"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function show(Resume $resume)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume)
    {
        //
    }
}
