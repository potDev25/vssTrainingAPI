<?php

namespace App\Http\Controllers;

use App\Models\ModeQuestion;
use App\Models\Site;
use App\Services\ModeQuestionServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModeQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /** Fetch all Mode Questions */
        $questions = ModeQuestion::get();
        return response($questions);
    }

    public function sites()
    {
        /** Fetch all Active Sites */
        $sites = Site::where('site_directorID', 'Active')->get();
        return response($sites);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ModeQuestionServices $service)
    {
        /**
         * Check if api token is present from the request
         */
        if($service->have_api_token($request) === ''){
            return response(['message_error' => 'unauthorized'], 422);
        }
        /** 
         * Validate incoming questions
         */
        $api_token = DB::table('apitoken')->where('token', $service->have_api_token($request))->first();
        if(!isset($api_token)){
            return response(['message_error' => 'api token not found'], 422);
        }

        if(!$service->question_validated($request)){
            /** Response if input is not complete or error validation */
            return response(['message_error' => 'Please Complete Input'], 422);
        }
            
        /** Insert data to database */

        if($service->is_questions_stored($request)){
            return response(200);
        }
        return response(500);
    }

    /**
     * Display the specified resource.
     */
    public function show(ModeQuestion $modeQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeQuestion $modeQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeQuestion $modeQuestion)
    {
        //
    }
}
