<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\MyClass\Response;
use App\MyClass\Validations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function viewChangePassword(){
        return view('setting.change_password', [
            'title' => 'Ubah Password',
            'breadcrumbs' => [
                [
                    'title' => 'Ubah Password',
                    'link' => route('setting.change_password')
                ]
            ]
        ]);
    }

    public function actionChangePassword(Request $request, User $user){
        Validations::validateChangePassword($request);
        DB::beginTransaction();
        
        try{
            $password = $request->new_password;
            $user->setPassword($password);
            DB::commit();

            return Response::update();
        } catch(Exception $e){
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function viewProfile(){
        return view('setting.profile', [
            'title' => 'Profile',
            'breadcrumbs' => [
                [
                    'title' => 'Profile',
                    'link' => route('setting.profile')
                ]
            ]
        ]);
    }

    public function actionProfile(User $user,Request $request,) {
        Validations::validateProfile($request, $user);
        DB::beginTransaction();

        try{
            $user->updateUser($request->all());
            DB::commit();

            return Response::update();
        }
        catch(Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }
}
