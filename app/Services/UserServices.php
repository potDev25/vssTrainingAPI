<?php

    namespace App\Services;

    use App\Models\User;

    class UserServices {

        //change user status
        public function changeStatus(string $id) {
            $user = User::where('id', $id)->first();

            if($user->status === 'Active'){
                $user->status = 'Blocked';
            }else{
                $user->status = 'Active';
            }
            $user->save();

            return true;
        }

    }

?>