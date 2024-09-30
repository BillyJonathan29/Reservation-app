<?php

namespace App\Http\Controllers;

use App\Models\FnbMenu;
use App\MyClass\Response;
use App\MyClass\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FnbMenuController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            return FnbMenu::dataTable();
        };
        return view('fnb-menu.index',[
            'title' => 'Menu',
            'breadcrumbs'	=> [
				[
					'title'	=> 'Menu',
					'link'	=> route('fnb-menu')
				]
			]
        ]);
    }

    public function store(Request $request){
        Validations::validateFnbMenu($request);
        DB::beginTransaction();

        try{
            FnbMenu::storeFnbMenu($request->all());
            DB::commit();

            return Response::success();
        } catch(Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function get(FnbMenu $fnbMenu){
        try {
			return Response::success([
				'fnbMenu' => $fnbMenu
			]);
		} catch (Exception $e) {
			return Response::error($e);
		}
    }

    public function update(Request $request, FnbMenu $fnbMenu){
        Validations::validateFnbMenu($request);
        DB::beginTransaction();

        try{
            $fnbMenu->updateFnbMenu($request->all());
            DB::commit();

            return Response::update();
        } catch (Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function destroy(FnbMenu $fnbMenu){
        DB::beginTransaction();

        try{
            $fnbMenu->deleteFnbMenu();
            DB::commit();
            
            return Response::delete();
        } catch(Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function import(Request $request){
        Validations::validateImport($request);
		try {
			FnbMenu::importFromExcel($request);
			return Response::success();
		} catch (\Exception $e) {
			return Response::error($e);
		}
    }
}
