<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try {

            $jobs = Job::all();

            $response = [
                'success' => true,
                'data' => $jobs,
                'message' => "Jobs retrieved successfully"
            ];

            return response()->json($response, 200);
        } catch (Exception $error) {

            return response()->json([
                'success' => false,
                'data' => $error,
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
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'rate' => 'required|string',
                'location' => 'required|string',
                'job_type' => 'required|string',
                'workspace' => 'required|numeric',
                'responsibilities' => 'required|array',
                'requirements' => 'required|array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => $validator->errors()->all()
                ], 422);
            }
            
            $company = User::findOrFail($request->user()->id)->company;

            $job = new Job();

            $job->title = $request->title;
            $job->description = $request->description;
            $job->rate = $request->rate;
            $job->location = $request->location;
            $job->job_type = $request->job_type;
            $job->workspace = $request->workspace;
            $job->responsibilities = json_encode($request->responsibilities);
            $job->requirements = json_encode($request->requirements);
            $job->company_id = $company->id;
            $job->save();

            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => "Job created successfully"
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error->getMessage(),
                'message' => "Falied to create job"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        try {
            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => "Jobs retrieved successfully"
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error,
                'message' => "Falied to retrieve jobs"
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'string|max:255',
                'desctription' => 'string',
                'hours' => 'string',
                'rate' => 'string',
                'location' => 'string',
                'job_type' => 'string',
                'workspace' => 'numeric',
                'responsibilities' => 'array',
                'requirements' => 'array'
            ]);

            if ($validator->falis()) {
                return response()->json([
                    'success' => false,
                    'data' => $validator->errors()->all()
                ], 422);
            }

            $job->title = $request->title || $job->title;
            $job->description = $request->description || $job->description;
            $job->hours = $request->hours || $job->hours;
            $job->rate = $request->rate || $job->rate;
            $job->location = $request->location || $job->location;
            $job->job_type = $request->job_type || $job->job_type;
            $job->workspace = $request->workspace || $job->workspace;
            $job->responsibilities = json_encode($request->responsibilities) || $job->responsibilities;
            $job->requirements = json_encode($request->requirements) || $job->requirements;
            $job->save();

            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => "Jobs updated successfully"
            ]);

        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error,
                'message' => "Falied to update jobs"
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $Job
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        //
        try {

            $job->delete();
            return response()->json([
                'success' => true,
                'data' => $job,
                'message' => "Jobs deleted successfully"
            ]);
            
            
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error,
                'message' => "Falied to delete jobs"
            ], 500);
        }
    }
}
