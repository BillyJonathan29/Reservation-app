<?php

namespace App\Http\Controllers;
use App\Models\Facilitie;
use App\MyClass\Response;
use App\MyClass\Validations;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilitieController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return Facilitie::dataTable();
        }
        return view('facilitie.index' ,[
            'title' => 'Fasilitas',
            'breadcrumbs' => [
                [
                    'title' => 'Fasilitas',
                    'link' => route('facilitie')
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        Validations::validateStoreFacilitie($request);
        // dd($request->all());
        DB::beginTransaction();

        try{
            $facilitie = Facilitie::facilitieCreate($request->all());
            $facilitie->saveFile($request);
            DB::commit();

            return Response::success();
        } catch(Exception $e){
            DB::rollback();

            return Response::error($e);
        }
    }

    public function get(Facilitie $facilitie)
    {
        try{
            return Response::success([
                'facilitie' => $facilitie
            ]);
        } catch (Exception $e){
            return Response::error($e);
        }
    }

    public function update(Request $request, Facilitie $facilitie)
    {
        // dd($request->all());
        Validations::validateUpdateFacilitie($request);
        DB::beginTransaction();


        try{
            $facilitie->facilitieUpdate($request->all());
            // if($request->file('file_icon')){ 
            //     $facilitie->saveFile($request);
            // }

            DB::commit();
            return Response::success();
        } catch (Exception $e) {

            DB::rollback();
            return Response::error($e);
        }
        
    }

    public function destroy(Facilitie $facilitie)
    {
        DB::beginTransaction();

        try{
            $facilitie->facilitieDestroy();
            $facilitie->removeFacilitiePhoto(); 
            DB::commit();

            return Response::success();
        } catch (Exception $e)
        {
            Db::rollBack();

            return Response::error($e);
        }
    }

    public function import(Request $request){
        Validations::validateImport($request);
        try {
			Facilitie::importFacilitieFromExcel($request);
			return Response::success();
		} catch (\Exception $e) {
			return Response::error($e);
		}
    }
}
