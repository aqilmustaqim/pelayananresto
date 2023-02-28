<?php

namespace App\Controllers;

use App\Database\Migrations\UserRole;
use \App\Models\UsersModel; // Memanggil User Model Dari Class Model
use \App\Models\UserRoleModel;

class Users extends BaseController
{

	//Membuat Variabel Untuk Menampung UsersModel
	protected $usersModel;
	protected $userRole;

	public function __construct()
	{
		//Masukkan Users Model Ke Dalam Variabel
		$this->usersModel = new UsersModel();
		$this->userRole = new UserRoleModel();
	}

	public function index()
	{
		//cek status login
		if (!session()->has('logged_in')) {
			session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
			return redirect()->to(base_url());
		} else {
			if (session()->get('role_id') != 1) {
				if (session()->get('role_id') == 2) {
					return redirect()->to(base_url('pelayan'));
				} else if (session()->get('role_id') == 3) {
					return redirect()->to(base_url('koki'));
				} else if (session()->get('role_id') == 4) {
					return redirect()->to(base_url('kasir'));
				} else if (session()->get('role_id') == 5) {
					return redirect()->to(base_url('koki'));
				}
			}
		}
		//Query JOIN TABEL USER DAN USER_ROLE
		$db      = \Config\Database::connect();
		$builder = $db->table('users');
		$builder->select('users.id as id_users, user_role.id as id_role, nama, email, is_active, role_id, created_at,role');
		$builder->join('user_role', 'users.role_id = user_role.id');
		$query = $builder->get();
		$users = $query->getResultArray();


		//QUERY USER_ROLE
		$role = $this->userRole->findAll();

		$data = [
			'title' => 'RestoServe || Data User',
			'users' => $users,
			'role' => $role,
			'validation' => \Config\Services::validation()
		];

		return view('users/index', $data);
	}

	public function hapusData($id)
	{
		//Hapus Data Berdasarkan ID
		if ($this->usersModel->delete($id)) {
			session()->setFlashdata('users', 'Dihapuskan');
			return redirect()->to(base_url('users'));
		}
	}

	public function tambahUser()
	{
		//Masukkan Users Ke Database
		if ($this->usersModel->save([
			'nama' => $this->request->getVar('nama'),
			'email' => $this->request->getVar('email'),
			'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
			'foto' => 'default.png',
			'is_active' => 1,
			'role_id' => $this->request->getVar('role')
		])) {
			//Kasih Flash Message
			// session()->setFlashdata('users', 'Ditambahkan');
			// return redirect()->to(base_url('users'));
			echo 'berhasil';
		}
	}


	public function ubahUser($id)
	{
		if ($this->usersModel->save([
			'id' => $id,
			'nama' => $this->request->getVar('nama'),
			'email' => $this->request->getVar('email'),
			'role_id' => $this->request->getVar('role'),
			'is_active' => $this->request->getVar('is_active')
		])) {
			//Kasih Flash Message
			session()->setFlashdata('users', 'Diubah');
			return redirect()->to(base_url('users'));
		}
	}

	public function profile()
	{

		if (!session()->has('logged_in')) {
			session()->setFlashdata('login', 'Silahkan Login Terlebih Dahulu !');
			return redirect()->to(base_url());
		}
		$user = $this->usersModel->where(['email' => session()->get('email')])->first();

		$data = [
			'title' => 'RestoServe || Profile',
			'users' => $user,
			'validation' => \Config\Services::validation()
		];

		return view('users/profile', $data);
	}

	public function updateProfile()
	{
		//Tangkap Data Ajax
		$id = $this->request->getVar('id');
		$nama = $this->request->getVar('nama');

		//Update Database
		if ($this->usersModel->save([
			'id' => $id,
			'nama' => $nama
		])) {
			echo "1";
		} else {
			echo 'Gagal Edit Profile';
		}
	}

	public function changePassword($id)
	{
		//Validasi Form
		if (!$this->validate([
			'password_lama' => [
				'rules' => 'required',
				'errors' => [
					'required' => '{field} Wajib Diisi ! '
				]
			],
			'password_baru' => [
				'rules' => 'required|matches[konfirmasi_password_baru]',
				'errors' => [
					'required' => '{field} Wajib Diisi ! ',
					'matches' => '{field} harus sama dengan konfirmasi password baru'
				]
			],
			'konfirmasi_password_baru' => [
				'rules' => 'required|matches[password_baru]',
				'errors' => [
					'required' => '{field} Wajib Diisi ! ',
					'matches' => '{field} harus sama dengan password baru'
				]
			]
		])) {
			//Jika gagal validasi
			return redirect()->to(base_url('users/profile'))->withInput();
		}

		//Jika Berhasil
		//Cek password Lamanya benar atau tidak
		$user = $this->usersModel->where(['id' => $id])->first();
		$passwordLama = password_verify($this->request->getVar('password_lama'), $user['password']);

		if ($passwordLama) {
			//Kalau password lama benar maka update password lama dengan password baru
			if ($this->usersModel->save([
				'id' => $id,
				'password' => password_hash($this->request->getVar('password_baru'), PASSWORD_DEFAULT)
			])) {

				return redirect()->to(base_url('auth/logout'));
			}
		} else {
			session()->setFlashdata('profile', 'Password Lama Anda Salah ! ');
			return redirect()->to(base_url('users/profile'));
		}
	}

	public function resetPassword($id)
	{
		//Ambil Inputan Password
		$password = $this->request->getVar('password');

		if ($password == '') {
			return redirect()->to(base_url());
		} else {

			//Edit Database
			if ($this->usersModel->save([
				'id' => $id,
				'password' => password_hash($password, PASSWORD_DEFAULT)
			])) {
				//Kalau Berhasil
				session()->setFlashdata('users', 'Reset Password User');
				return redirect()->to(base_url('users'));
			}
		}
	}
}
