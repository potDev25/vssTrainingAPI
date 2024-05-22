<?php
    namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

    class AuthServices{

        //login function
        public function loginUser($credentials) {
            $status = 0;
            //check if user status is active or blocked

            $user  = User::where('email', $credentials['email'])->first();
            if($user){
                if($user->status == 'Active'){
                    if(!Auth::attempt($credentials)){
                        //wrong credentials or invalid login
                        $status = 422;
                    }
                }else{
                    $status = 500;
                }
            }else{
                $status = 422;
            }

            return $status;
        }

    }
?>