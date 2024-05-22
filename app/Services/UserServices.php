<?php

    namespace App\Services;

    use App\Models\User;

    class UserServices {

        //change user status
        public function changeStatus(string $id) : bool {
            $user = User::where('id', $id)->first();

            if($user){
                if($user->status === 'Active'){
                    $user->status = 'Blocked';
                }else{
                    $user->status = 'Active';
                }
                $user->save();
    
                return true;
            }
            return false;
        }

        public function storeUser($request) : bool {
            $data = $request->validated();
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('media', 'public');
            }
    
            $saveUser = User::create($data);

            if($saveUser){
                return true;
            }
            return false;
        }

    }

?>