<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Admin extends BaseController
{

	protected $barangModel;
	public function __construct()
	{
		$this->barangModel = new BarangModel();
	}
	public function index()
	{
		$data = [
			'title' => 'Dashboard'
		];

		return view('admin/index', $data);
	}
	public function view()
	{
		$admin = $this->barangModel->findAll();
		$data = [
			'title' => 'View Barang',
			'barang' => $this->barangModel->getBarang()
		];

		return view('admin/index', $data);
	}

	public function detail($slug)
	{
		$data = [
			'title' => 'Detail Barang',
			'barang' => $this->barangModel->getBarang()
		];

		if (empty($data['barang'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang ' . $slug . 'tidak ditemukan');
		}

		return view('admin/detail', $data);
	}

	public function create()
	{
		$data = [
			'title' => 'Form penambahan data Barang.',
			'validation' => \Config\Services::validation()
		];

		return view('admin/create', $data);
	}

	public function save()
	{
		if (!$this->validate([
			'nama' => [
				'rules' => 'required|is_unique[barang.nama]',
				'errors' => [
					'is_unique' => '*{field} barang sudah ada sebelumnya, silahkan gunakan nama lain.',
					'required' => '*{field} barang belum diisi, silahkan isi terlebih dahulu.'
				]
			],
			'gambar' => [
				'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
				'errors' => [
					'max_size' => 'Ukurang gambar terlalu besar',
					'is_image' => 'Silahkan sisipkan gambar saja',
					'mime_in' => 'Silahkan sisipkan gambar saja'
				]
			]
		])) {
			return redirect()->to('/admin/create/')->withInput();
		}

		$fileGambar = $this->request->getFile('gambar');

		if ($fileGambar->getError() === 4) {
			$namaGambar = 'default.jpg';
		} else {
			$namaGambar = $fileGambar->getRandomName();
			$fileGambar->move('asset/img', $namaGambar);
		}

		$slug = url_title($this->request->getVar('nama'), '-', true);

		$this->barangModel->save([
			'nama' => $this->request->getVar('nama'),
			'slug' => $slug,
			'deskripsi' => $this->request->getVar('deskripsi'),
			'gambar' => $namaGambar

		]);

		session()->setFlashdata('pesan', 'Barang berhasil disimpan');
		return redirect()->to('/admin');
	}

	public function delete($idBarang)
	{
		$barang = $this->barangModel->find($idBarang);

		if ($barang['gambar'] != 'default.jpg') {
			unlink('asset/img/' . $barang['gambar']);
		}
		$this->barangModel->delete($idBarang);

		session()->setFlashdata('pesan', 'Barang berhasil terhapus.');

		return redirect()->to('/admin');
	}

	public function edit($slug)
	{
		$data = [
			'title' => 'Form edit data Barang.',
			'validation' => \Config\Services::validation(),
			'barang' => $this->barangModel->getBarang($slug)
		];

		return view('admin/edit', $data);
	}

	public function update($idBarang)
	{
		$barangLama = $this->barangModel->getBarang($this->request->getVar('slug'));

		if ($barangLama['nama'] == $this->request->getVar('nama')) {
			$rule_nama = 'required';
		} else {
			$rule_nama = 'required|is_unique[barang.nama]';
		}

		if (!$this->validate([
			'nama' => [
				'rules' => $rule_nama,
				'errors' => [
					'is_unique' => '*{field} barang sudah ada, sialhkan gunakan nama lain.',
					'required' => '*{field} barang kosong, silahkan isi terlebih dahulu.'
				]
			],
			'gambar' => [
				'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png'
			],
			'errors' => [
				'max_size' => 'Ukuran gambar terlalu besar',
				'is_image' => 'File yang di upload hanya gambar .jpg, .png',
				'mime_in' => 'File yang di upload hanya gambar .jpg, .png'
			]

		])) {
			return redirect()->to('/edit/' . $this->request->getVar('slug'))->withInput();
		}

		$fileGambar = $this->request->getFile('gambar');

		if ($fileGambar->getError() == 4) {
			$namaGambar = $this->request->getVar('gambarLama');
		} else {
			$namaGambar = $fileGambar->getRandomName();

			$fileGambar->move('asset/img/', $namaGambar);
			unlink('asset/img/' . $this->request->getVar('gambarLama'));
		}

		$slug = url_title($this->request->getVar('nama'), '-', true);

		$this->barangModel->save([
			'idBarang' => $idBarang,
			'nama' => $this->request->getVar('nama'),
			'slug' => $slug,
			'deskripsi' => $this->request->getVar('deskripsi'),
			'gambar' => $namaGambar
		]);

		session()->setFlashdata('pesan', 'Barang berhasil disimpan.');
		return redirect()->to('/admin');
	}




	//--------------------------------------------------------------------

}
