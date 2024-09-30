<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\MyClass\SimpleXLSX;
use Illuminate\Support\Facades\DB;
use Exception;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'rooms';
    protected $guarded = ['id'];

    // Relasi Antar Tabel
    public function roomFacility(){
        return $this->hasMany(RoomFacilitie::class, 'id_room');
    }

    // Method action
    public static function storeRoom($request)
    {
        return self::create($request);
    }

    public function updateRoom(array $request)
    {
        $this->update($request);
        return $this;
    }

    public function deleteRoom()
    {
        $this->delete();
        $this->removeRoomFacility();
        return $this;
    }


    public function removeRoomFacility(){
        $roomFacility = RoomFacilitie::where('id_room', $this->id)->delete();
        return $roomFacility;
    }

    // Data Table
    public static function dataTable()
    {
        $data = self::select([ 'rooms.*' ]);
        return DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $action = '<div class="dropdown">
                    <button class="btn btn-danger px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Aksi
                    </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item edit" href="javascript:void(0);" data-edit-href="' . route('room.update', $data->id) . '" data-get-href="' . route('room.get', $data->id) . '">
                        <i class="fas fa-pencil-alt mr-1"></i> Edit
                    </a>
                    <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>' . $data->room_name . '</strong>?" data-delete-href="' . route('room.destroy', $data->id) . '">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>
                </div>
            </div>';
            return $action;
            })
            ->editColumn('room_pacilities', function($data){
                return $data->roomFacility->pluck('facility.facility_name')->implode(', ');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    // Import Excel
    public  static function importRoomFromExcel($request){
		return self::importFromExcel($request);
	}

    public static function importFromExcel($request) {
        $amount = 0;

		if(!empty($request->file_excel))
		{
			$file = $request->file('file_excel');
			$filename = date('YmdHis_').rand(100,999).'.'.$file->getClientOriginalExtension();
			$file->move(storage_path('app/public/temp_files'), $filename);
			$path = storage_path('app/public/temp_files/'.$filename);
			$parseData = SimpleXLSX::parse($path);

			if($parseData)
			{
				$iter = 0;
				foreach($parseData->rows() as $row)
				{
					$iter++;
					if($iter == 1) continue;

					if(!empty($row[0])) {
						$room = self::where('room_number', $row[0])
										->first();

						if(!$room) {
							DB::beginTransaction();
							try {
								self::create([
									'room_number'=> $row[0],
                                    'room_name' => $row[1],
                                    'floor_number'=> $row[2],
								]);
								$amount++;
								DB::commit();
							} catch (Exception $e) {
								DB::rollback();
							}
						}
					}
				}
			}

			\File::delete($path);
		}

		return $amount;
    }

    // Function untuk Di Gunakan Di Dashboard
    public static function totalRoom(){
        $totalRoom = DB::table('rooms')->count();
        return $totalRoom;
    }
}