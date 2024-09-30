<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RoomFacilitie extends Model
{
    protected $guarded= [''];


    // Relasi Antar Tabel
    public function room(){
        return $this->hasOne(Room::class ,'id_room');
    }
    
    public function facility(){
        return $this->belongsTo(Facilitie::class ,'id_facility');
    }

    // Method Action
    public static function createRoomFacilitie(array $data){
        $idRoom = $data['idRoom'];
        $idFacility = $data['idFacility'];
        
        return self::create([
            'id_room' => $idRoom,
            'id_facility' => $idFacility
        ]);
    }

    // Data Tables ServerSide
    public static function dataTable(){
        $data = self::select([ 'room_facilities.*' ]);
        return DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $action = '<div class="dropdown">
                    <button class="btn btn-danger px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Aksi
                    </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item edit" href="' . route('room-facilitie.edit', $data->id) . '">
                        <i class="fas fa-pencil-alt mr-1"></i> Edit
                    </a>
                    <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>Data Ini</strong>?" data-delete-href="' . route('room-facilitie.destroy', $data->id) . '">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>
                </div>
            </div>';
            return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
