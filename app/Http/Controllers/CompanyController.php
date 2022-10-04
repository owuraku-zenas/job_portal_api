<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $company = Company::all();

            $response = [
                'success' => true,
                'data' => $company,
                'message' => "Companies retrieved successfully"
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
        //
        if (User::findOrFail($request->user()->id)->company) {
            return response()->json([
                'success' => false,
                'message' => "Company Already Exists for User"
            ], 422);
        }


        try {
            $validator = Validator::make($request->all(), [
                'website' => "required",
                'about' => "required",
                'linked_in' => "required",
                'twitter' => "string",
                'instagram' => "string",
                'category' => "string"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'data' => $validator->errors()->all()
                ], 422);
            }

            // Check if category in DB
            if (Category::where('type', $request->category)->exists()) {
                $category = Category::where('type', $request->category)->first();
            } else {
                $category = Category::create([
                    'type' => $request->category
                ]);
            }

            $company = Company::create([
                'website' => $request->website,
                'about' =>  $request->about,
                'linked_in' =>  $request->linked_in,
                'user_id' => $request->user()->id,
                'category_id' => $category->id,
                'instagram' =>  $request->instagram ? $request->instagram : null,
                'twitter' => $request->twitter ? $request->twitter : null,
            ]);

            return response()->json([
                'success' => true,
                'data' => $company,
                'message' => "Company Created Successfully"
            ]);
        } catch (Exception $error) {
            return response()->json([
                'success' => false,
                'data' => $error->getMessage(),
                'message' => "Falied to create Company"
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
