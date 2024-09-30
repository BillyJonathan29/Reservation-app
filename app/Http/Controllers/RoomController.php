<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Facilitie;
use App\MyClass\Response;
use App\MyClass\Validations;
use Illuminate\Http\Request;
use App\Models\RoomFacilitie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return Room::dataTable($request);
        }

        return view('room.index', [
            'title'            => 'Ruangan',
            'breadcrumbs'    => [
                [
                    'title'    => 'Ruangan',
                    'link'    => route('room')
                ]
            ],
            'facilitys' => Facilitie::all()
        ]);
    }

    public function store(Request $request)
    {
        Validations::validateStoreRoom($request);
        DB::beginTransaction();

        try{
            $room = Room::storeRoom($request->all());
            $idRoom =  $room->id;
            $fasilitas = $request->id_facility;
            foreach ($fasilitas as $key => $f) {
                if($f != null){
                    $dataRoomFasilitas = [
                        'idRoom' => $idRoom,
                        'idFacility' => $f
                    ];
                    RoomFacilitie::createRoomFacilitie($dataRoomFasilitas);
                }
            }
            
            DB::commit();
            return Response::success();
        } catch(\Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function get(Room $room, RoomFacilitie $roomFacilitie)
    {
        try{
            return Response::success([
                'room' => $room,
                'roomFacility' => $roomFacilitie
            ]);
        } catch(\Exception $e) {
            return Response::error($e);
        }
    }

    public function update(Room $room, Request $request)
    {
        Validations::validateStoreRoom($request);
        DB::beginTransaction();

        try{
            $room->updateRoom($request->all());
            $room->removeRoomFacility();
            $idRoom =$room->id;
            $fasilitas = $request->id_facility;
            
            foreach ($fasilitas as $key => $f) {
                if($f != null){
                    $dataRoomFasilitas = [
                        'idRoom' => $idRoom,
                        'idFacility' => $f
                    ];
                    RoomFacilitie::createRoomFacilitie($dataRoomFasilitas);
                }
            }

            DB::commit();

            return Response::success();
        } catch(\Exception $e){
            DB::rollBack();

            return Response::error($e);
        }
    }

    public function import(Request $request){
        Validations::validateImport($request);
		try {
			Room::importFromExcel($request);
			return Response::success();
		} catch (\Exception $e) {
			return Response::error($e);
		}
    }

    public function destroy(Room $room)
    {
        DB::beginTransaction();

        try {
            $room->deleteRoom();
            DB::commit();

            return Response::delete();
        } catch (\Exception $e) {
            DB::rollBack();

            return Response::error($e);
        }
    }
}