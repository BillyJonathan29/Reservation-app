<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Yajra\DataTables\Facades\DataTables;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'active_at', 'updated_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Method action
    public static function storeUser($request)
	{
		$user = self::create($request);
		
		return $user;
	}

    public function updateUser($request){
        return $this->update($request);
    }

    public function deleteUser(){
        return $this->delete();
    }

    public function setPassword($password)
	{
		$this->update([
			'password'	=> Hash::make($password)
		]);
		return $this;
	}

    // Chnage Password
    public function changePassword($request){
        $this->update([
            'password'	=> Hash::make($request)
        ]);
        return $this;
    }


    // data Table 
    public static function dataTable(){
        $data = self::select([ 'users.*' ]);

        return DataTables::eloquent($data)
        ->addColumn('action', function ($data) {
            $action = '
                <div class="dropdown">
                    <button class="btn btn-danger px-2 py-1 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Pilih Aksi
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item edit" href="javascript:void(0);" data-edit-href="' . route('user.update', $data->id) . '" data-get-href="' . route('user.get', $data->id) . '">
                            <i class="fas fa-pencil-alt mr-1"></i> Edit
                        </a>
                        <a class="dropdown-item delete" href="javascript:void(0)" data-delete-message="Yakin ingin menghapus <strong>' . $data->name . '</strong>?" data-delete-href="' . route('user.destroy', $data->id) . '">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </a>
                    </div>
                </div>
            ';
            return $action;
        })
        ->editColumn('active_at', function($data){
            return $data->active_at->format('Y/m/d - H:i:s');
        })
        ->rawColumns([ 'action' ])
        ->make(true);
    }

    // Avatar
    public function isHasAvatar()
	{
		if(empty($this->avatar)) return false;
		return \File::exists($this->avatarPath());
	}

	public function avatarPath()
	{
		return storage_path('app/public/avatars/'.$this->avatar);
	}

	public function avatarLink()
	{
		if($this->isHasAvatar()) {
			return url('storage/avatars/'.$this->avatar);
		}

		return url('img/default-avatar.jpg');
	}

	public function setAvatar($request)
	{
		if(!empty($request->upload_avatar)) {
			$this->removeAvatar();
			$file = $request->file('upload_avatar');
			$filename = date('YmdHis_').$file->getClientOriginalName();
			$file->move(storage_path('app/public/avatars'), $filename);
			$this->update([
				'avatar' => $filename,
			]);
		}

		return $this;
	}

	public function removeAvatar()
	{
		if($this->isHasAvatar()) {
			\File::delete($this->avatarPath());
			$this->update([
				'avatar' => null,
			]);
		}

		return $this;
	}

}
