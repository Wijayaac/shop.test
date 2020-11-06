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
		$data = [
			'title' => 'List Produk',
			'barang' => $this->barangModel->getBarang()
		];

		return view('admin/view', $data);
	}

	public function detail($slug)
	{
		$data = [
			'title' => 'Detail Produk',
			'barang' => $this->barangModel->getBarang($slug)
		];

		if (empty($data['barang'])) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException('Produk' . $slug . 'tidak ditemukan');
		}

		return view('admin/detail', $data);
	}

	public function create()
	{
		$data = [
			'title' => 'Tambah Produk',
			'validation' => \Config\Services::validation()
		];

		return view('admin/create', $data);
	}

	public function save()
	{
		// validasi input yang dilakukan
		if (!$this->validate([
			'nama' => [
				'rules' => 'required|is_unique[barang.nama]',
				'errors' => [
					'required' => '*{field} produk harus diisi',
					'is_unique' => '*{field} produk sudah ada sebelumnya'
				]
			],
			'gambar' => [
				'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpeg,image/jpg,image/png]',
				'errors' => [
					'max_size' => '*ukuran gambar terlalu besar',
					'is_image' => '*file yang diupload hanya gambar',
					'mime_in' => '*file yang diupload hanya gambar'

				]
			]
		])) {
			return redirect()->to('create')->withInput();
		}

		// input gambar

		$fileGambar = $this->request->getFile('gambar');
		// cek gambar jika tidak ada maka pakai default
		if ($fileGambar->getError() == 4) {
			$namaGambar = 'default.png';
		} else {
			// generate nama file random dan pindahkan ke folder img
			$namaGambar = $fileGambar->getRandomName();
			$fileGambar->move('asset/img', $namaGambar);
		}

		// buat slug
		$slug = url_title($this->request->getVar('nama'), '-', true);

		$this->barangModel->save(
			[
				'nama' => $this->request->getVar('nama'),
				'slug' => $slug,
				'deskripsi' => $this->request->getVar('deskripsi'),
				'gambar' => $namaGambar
			]
		);

		session()->setFlashdata('pesan', 'Produk berhasil tersimpan');

		return redirect()->to('view');
	}

	public function delete($idBarang)
	{
		// mencari gambar berdasarkan id dan jangan hapus gambar jika default
		$barang = $this->barangModel->find($idBarang);

		if ($barang['gambar'] != 'default.png') {
			unlink('asset/img' . $barang['gambar']);
		}

		$this->barangModel->delete($idBarang);

		session()->setFlashdata('pesan', 'Produk berhasil dihapus');

		return redirect()->to('/admin/view/');
	}

	public function edit($slug)
	{
		$data = [
			'title' => 'Edit Produk',
			'validation' => \Config\Services::validation(),
			'barang' => $this->barangModel->getBarang($slug)
		];

		return view('/admin/edit', $data);
	}

	public function update($idBarang)
	{
		$barangLama = $this->barangModel->getBarang($this->request->getVar('slug'));

		// cek judul agar ga sama dengan lainnya saat diupdate

		if ($barangLama['nama'] == $this->request->getVar('nama')) {
			$ruleNama = 'required';
		} else {
			$ruleNama = 'required|is_unique[barang.nama]';
		}

		// validasi update

		if (!$this->validate([
			'nama' => [
				'rules' => $ruleNama,
				'errors' => [
					'is_unique' => '*{field} produk sudah ada sebelumnya',
					'required' => '*{field} produk harus diisi'
				]
			],
			'gambar' => [
				'rules' => 'max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpeg,image/jpg,image/png]',
				'errors' => [
					'max_size' => '*ukuran gambar terlalu besar',
					'is_image' => '*file yang diupload hanya gambar',
					'mime_in' => '*file yang diupload hanya gambar'

				]
			]
		])) {
			return redirect()->to('/admin/edit/' . $this->request->getVar('slug'))->withInput();
		}

		// cek gambar berubah atau tidak 

		$fileGambar = $this->request->getFile('gambar');

		if ($fileGambar->getError() == 4) {
			$namaGambar = $this->request->getVar('gambarLama');
		} elseif ($this->request->getVar('gambarLama') != 'default.png') {
			unlink('asset/img/' . $this->request->getVar('gambarLama'));

			$namaGambar = $fileGambar->getRandomName();

			$fileGambar->move('asset/img/', $namaGambar);
		} else {
			$namaGambar = $fileGambar->getRandomName();

			$fileGambar->move('asset/img/', $namaGambar);
		}


		$slug = url_title($this->request->getVar('nama'), '-', true);

		$this->barangModel->update($idBarang, [
			'nama' => $this->request->getVar('nama'),
			'slug' => $slug,
			'deskripsi' => $this->request->getVar('deskripsi'),
			'gambar' => $namaGambar
		]);

		session()->setFlashdata('pesan', 'Produk berhasil diupdate');

		return redirect()->to('/admin/view');
	}

	//--------------------------------------------------------------------

}
