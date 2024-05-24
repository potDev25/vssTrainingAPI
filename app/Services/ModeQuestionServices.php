<?php

namespace App\Services;

use App\Models\ModeQuestion;
use App\Models\Site;
use Carbon\Carbon;

class ModeQuestionServices {

    /**
     * Check if API TOKEN is present from the request
     */
    public function have_api_token($request) : string{
        $request_apit_token = $request->all();
        $api_token = true;
        $token = '';
        for ($API_INDEX = 0; $API_INDEX < count($request_apit_token); $API_INDEX++) { 
            if($request_apit_token[$API_INDEX]['api_token'] == null){
                $api_token = false;
                break;
            }
        }

        if($api_token){
            $token = $request_apit_token[0]['api_token'];
        }

        return $token;
    }

    /**
     * Validate requests
     */
    public function question_validated($request) : bool{
        $va_err = true;
        $requests = $request->all();
        for ($QUESTION_INDEX = 0; $QUESTION_INDEX < count($requests); $QUESTION_INDEX++) { 
            if($requests[$QUESTION_INDEX]['question'] == null){
                $va_err = false;
                break;
            }
        }

        for ($DAY_INDEX = 0; $DAY_INDEX < count($requests); $DAY_INDEX++) { 
            if($requests[$DAY_INDEX]['day'] == null){
                $va_err = false;
                break;
            }
        }

        for ($SITE_INDEX = 0; $SITE_INDEX < count($requests); $SITE_INDEX++) { 
            if($requests[$SITE_INDEX]['site_id'] == null){
                $va_err = false;
                break;
            }
        }

        return $va_err;
    }

    public function is_questions_stored($request){
        // $questions = $request->question;

        $all_request = $request->all();
        $questions = [];
        $days = [];
        $site_id = [];

        foreach ($all_request as $key => $value) {
            $questions[] = $value['question'];
            $days[] = $value['day'];
            $site_id[] = $value['site_id'];
        }

        /** Store data to $data array for insertion */

        $data = [];

        /** Get current data for created_at and updated_at */

        $timestamp = Carbon::now();
        foreach ($questions as $key => $question) {

            /** Get site name */

            $site = Site::where('id', $site_id[$key])->first();

            /** Push value to $data array 
             * Prepare data for insertion process
            */

            $data[] = [
                'question' => $question,
                'day' => $days[$key],
                'site_id' =>  $site_id[$key],
                'site_name' => $site->site_name,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        $save = ModeQuestion::insert($data);

        if($save){
            return true;
        }
        return false;
    }

}