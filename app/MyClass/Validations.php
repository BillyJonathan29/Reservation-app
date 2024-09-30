<?php

namespace App\MyClass;

use App\Models\User;
use App\Rules\MatchOldPassword;

class Validations
{

	public static function loginValidate($request){
		$request->validate([
			'username' => 'required|exists:users,username',
		],[
			'username.required' => 'Username wajib diisi',
			'username.exists' => 'Username tidak ditemukan',
		]);
	}

	public static function validateImport($request){
		$request->validate([
			'file_excel' => 'required|file|mimes:xlsx,xls',
		], [
			'file_excel.required' => 'File excel wajib diisi',
			'file_excel.file' => 'Wajib bernilai file',
			'file_excel.mimes' => 'Hanya mendukung ekstensi .xlsx atau .xls',
		]);
	}

	public static function validateFnbMenu($request){
		$request->validate([
			'menu_name' => 'required',
			'type' => 'required',
			'price' => 'required'
		],[
			'menu_name.required' => 'Nama Menu Wajib Diisi',
			'type.required' => 'Jenis Menu Wajib Diisi',
			'price.required' => 'Harga Menu Wajib Diisi'
		]);
	}

	public static function validateUser($request) {
		$request->validate([
			'name' => 'required',
			'role' => 'required',
			'email' => '|required|email|unique:users,email',
			'username' => 'required|unique:users,username',
			'password' => 'required|min:6',
			'confirmation' => 'required|same:password',
		],[
			'name.required' => 'Nama Wajib Di Isi',
			'role.required' => 'Role Wajib Diisi',
			'email.required' => 'Email Wajib Di Isi',
			'email.email' => 'Email Tidak valid',
			'email.unique' => 'Email Sudah Terdaftar',
			'username.required' => 'Username Wajib Di Isi',
			'username.unique' => 'Username Sudah Terdaftar',
			'password.required' => 'Password Wajib Di Isi',
			'confirmation.required' => 'Silahkan Konfirmasi Password',
			'confirmation.same' => 'Password Tidak Valid',
		]);
	}

	public static function updateUser($request, $user) {
		$request->validate([
			'name' => 'required',
			'role' => 'required',
			'email' => 'required|email|unique:users,email,'.$user->id,
			'username' => 'required|unique:users,username,'.$user->id,
		],[
			'name.required' => 'Nama Wajib Di Isi',
			'role.required' => 'Role Wajib Diisi',
			'email.required' => 'Email Wajib Di Isi',
			'email.unique' => 'Email Sudah Terdaftar',
			'email.email' => 'Email Tidak valid',
			'username.required' => 'Username Wajib Di Isi',
			'username.unique' => 'Username Sudah Terdaftar',
		]);
	}

	public static function validateStoreRoom($request){
		$request->validate([
			'room_number' => 'required',
			'room_name' => 'required',
			'floor_number' => 'required'
		],[
			'room_number.required' => 'Nomor Ruangan Wajib Diisi',
			'room_name.required' => 'Nama Ruangan Wajib Diisi',
			'floor_number.required' => 'Nomor Lantai Wajib Diisi'
		]);
	}

	public static function validateProfile($request, $user){
		$request->validate([
			'name' => 'required',
			'username' => 'required|unique:users,username,'.$user->id,
			'email' => 'required|email|unique:users,email,'.$user->id,
		],[
			'name.required' => 'Nama Wajib Di Isi',
			'username.required' => 'Username Wajib Di Isi',
			'username.unique' => 'Username Sudah Terdaftar',
			'email.required' => 'Email Wajib Di Isi',
			'email.unique' => 'Email Sudah Terdaftar',
		]);
	}

	public static function validateChangePassword($request){
		$request->validate([
			'password' => ['required', new MatchOldPassword],
			'new_password' => 'required|min:6',
			'confirmation' => 'required|same:new_password',
		],[
			'password.required' => 'Password lama wajib diisi',
			'new_password.required' => 'Password baru wajib diisi',
			'new_password.min' => 'Password minimal 6 karakter',
			'confirmation.required' => 'Konfirmasi password wajib diisi',
			'confirmation.same' => 'Konfirmasi password tidak sama',
		]);
	}

	public static function validateStoreFacilitie($request){
		$request->validate([
			'facility_name' => 'required',
			'file_icon' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,tiff|max:2048',
			'available_on_all_rooms' => 'required'
		],[
			'facility_name.required' => 'Nama Fasilitas Wajib Diisi',
			'file_icon.required' => 'Gambar Wajib Di Isi Wajib Diisi',
			'file_icon.mimes' => 'Hanya Mendukung ekstensi .pdf, .jpg, .jpeg, .png, .gif, .tiff',
			'available_on_all_rooms.required' => 'Inputan Ini Wajib Di Di isi'
		]);
	}
	public static function validateUpdateFacilitie($request){
		$request->validate([
			'facility_name' => 'required',
			'file_icon' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,tiff|max:2048',
			'available_on_all_rooms' => 'required'
		],[
			'facility_name.required' => 'Nama Fasilitas Wajib Diisi',
			'available_on_all_rooms.required' => 'Inputan Ini Wajib Di Di isi'
		]);
	}
}
