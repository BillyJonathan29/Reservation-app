<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use App\MyClass\SimpleXLSX;
use Illuminate\Support\Facades\DB;

class Facilitie extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Crud
    public static function facilitieCreate($request)
    {
        $facilitie = self::create($request);
        return $facilitie;
    }

    public function facilitieUpdate(array $request)
    {
        $this->removeFacilitiePhoto();
        $this->update($request);
        return $this;
    }

    public function facilitieDestroy()
    {
        $this->removeFacilitiePhoto();
        return $this->delete();
    }


    public function availableRoom()
	{
		return $this->available_on_all_rooms == 'Ya';
	}

	public function availableRoomTextHtml()
	{
		if ($this->availableRoom()) {
			return '<span class="text-success"> Ya </span>';
		} else {
			return '<span class="text-danger"> Tidak </span>';
		}
	}

	public function available()
	{
		$this->update([
			'available_on_all_rooms' => 'Ya',
		]);
		return $this;
	}

	public function noAvailable(){
		$this->available_on_all_rooms == 'Tidak';
	}


    // Upload foto To Storage
   public function facilitieFilePath()
    {
        return storage_path('app/public/facilitie_photo/' . $this->file_icon);
    }

    public function facilitiePhotoFileLink()
    {
        return url('storage/facilitie_photo/' . $this->file_icon);
    }

    public function facilitieFileLinkHtml()
    {
        if ($this->isHasFacilitiePhoto()) {
            $href = '<a href="' . $this->facilitiePhotoFileLink() . '" target="_blank"> Lihat Foto Fasilitas </a>';
            return $href;
        } else {
            return '<span class="text-danger"> Tidak Melampirkan Foto </span>';
        }
    }

    public function isHasFacilitiePhoto()
    {
        if(empty($this->file_icon)) return false;
        return \File::exists($this->facilitieFilePath());
    }

    public function removeFacilitiePhoto()
    {
        if ($this->isHasFacilitiePhoto()) {
            \File::delete($this->facilitieFilePath());
            // $this->update([
            //     'file_icon' => null
            // ]);
        }

        return $this;
    }

    public function saveFile($request)
    {
        if($request->hasFile('file_icon')) {
            $this->removeFacilitiePhoto();
            $file = $request->file('file_icon');
            $filename = date('YmdHis_') . $file->getClientOriginalName();
            $file->move(storage_path('app/public/facilitie_photo'), $filename);
            $this->update([
                'file_icon' => $filename,
            ]);
        }

        return $this;
    }


    public static function dataTable()
    {
        $data = self::select(['facilities.*']);
        return DataTables::eloquent($data)
            ->addColumn('action', function ($data) {
                $action = '<div class="dropdown">
                    <button class="btn btn-danger px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Aksi
                    </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item edit" href="javascript:void(0);" data-edit-href="' . route('facilitie.update', $data->id) . '" data-get-href="' . route('facilitie.get', $data->id) . '">
                        <i class="fas fa-pencil-alt mr-1"></i> Edit
                    </a>
                    <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>' . $data->facility_name . '</strong>?" data-delete-href="' . route('facilitie.destroy', $data->id) . '">
                        <i class="fas fa-trash mr-1"></i> Hapus
                    </a>
                </div>
            </div>';
                return $action;
            })
            ->editColumn('available_on_all_rooms', function ($data) {
				return $data->availableRoomTextHtml();
			})
            ->editColumn('file_icon', function($data){
				return $data->facilitieFileLinkHtml();
			})
            ->rawColumns(['action', 'file_icon', 'available_on_all_rooms'])
            ->make(true);
    }

    public static function importFacilitieFromExcel($request){
        return self::importFromExcel($request);
    }

    public static function importFromExcel($request){
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
						$facilitie = self::where('facility_name', $row[0])
										->first();

						if(!$facilitie) {
							DB::beginTransaction();
							try {
								self::create([
									'facility_name'=> $row[0],
                                    'available_on_all_rooms'=> $row[1]
								]);

								$amount++;
								DB::commit();
							} catch (\Exception $e) {
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
}
