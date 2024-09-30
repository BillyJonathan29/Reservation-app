<?php

namespace App\Models;

use Exception;
use App\MyClass\SimpleXLSX;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FnbMenu extends Model
{
    use HasFactory;

    protected $guarded = [''];
    
    // Function
    public function nominalText(){
        return 'Rp. '.number_format($this->price);
    }

    public function typeText(){
        if ($this->type == 'beverage') {
            return 'Minuman';
        } elseif ($this->type == 'food') {
            return 'Makanan';
        }  else {
            return $this->type;
        }
    }

    // Method Action
    public static function storeFnbMenu($request){
        return self::create($request);
    }

    public function updateFnbMenu($request){
        $this->update($request);
        return $this;
    }

    public function deleteFnbMenu(){
        $this->delete();
        return $this;
    }

    // data Table
    public static function dataTable(){
        $data = self::select([ 'fnb_menus.*' ]);
        return DataTables::eloquent($data)
        ->addColumn('action', function ($data) {
            $action = '
                <div class="dropdown">
                    <button class="btn btn-danger px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Aksi
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item edit" href="javascript:void(0);" data-edit-href="' . route('fnb-menu.update', $data->id) . '" data-get-href="' . route('fnb-menu.get', $data->id) . '">
                            <i class="fas fa-pencil-alt mr-1"></i> Edit
                        </a>
                        <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>' . $data->menu_name . '</strong>?" data-delete-href="' . route('fnb-menu.destroy', $data->id) . '">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </a>
                    </div>
                </div>
            ';
            return $action;
        })
        ->editColumn('price', function($data){
            return $data->nominalText();
        })
        ->editColumn('type', function($data){
            return $data->typeText();
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    // Import Excel
    public  static function importExpenseBrandFromExcel($request){
		return self::importFromExcel($request);
	}

    public  static function ubahValueType($row){
        if(strtolower($row) == 'makanan') {
            return 'food';
        } elseif(strtolower($row) == 'minuman') {
            return 'feverage';
        }
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
						$fnbMenu = self::where('menu_name', $row[0])
										->first();

						if(!$fnbMenu) {
							DB::beginTransaction();
							try {
								self::create([
									'menu_name'=> $row[0],
                                    'type' => self::ubahValueType($row[1]),
                                    'price'=> $row[2],
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
}
