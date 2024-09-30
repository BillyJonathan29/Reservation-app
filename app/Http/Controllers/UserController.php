<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\MyClass\Response;
use App\MyClass\Validations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    
    public function index(Request $request){
        if($request->ajax()){
            return User::dataTable();
        }
        return view('user.index', [
            'title' => 'User',
            'breadcrumbs' => [
                [
                'title' => 'User',
                'link' => route('user'),
                ]
            ]
        ]);
    }

    public function store(Request $request){
        Validations::validateUser($request);
        DB::beginTransaction();
        
        try{
            $user = User::storeUser($request->all());
            $user->setPassword($request->password);
            DB::commit();

            return Response::success();
        }  catch(Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function get(User $user){
        try {
			return Response::success([
				'user' => $user
			]);
		} catch (Exception $e) {
			return Response::error($e);
		}
    }

    public function update(Request $request, User $user){
        Validations::updateUser($request, $user);
        DB::beginTransaction();

        try{
            $user->updateUser($request->all());
            DB::commit();

            return Response::success();
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function destroy(User $user){
        DB::beginTransaction();
        try{
            $user->deleteUser();
            DB::commit();

            return Response::delete();
        } catch(Exception $e) {
            DB:: rollBack($e);

            return Response::error($e);
        }
    }
}
