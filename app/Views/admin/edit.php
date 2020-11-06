<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-5"> Form Tambah data Produk</h2>
            <form action="/admin/update/<?= $barang['idBarang']; ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" value="<?= $barang['slug']; ?>">
                <input type="hidden" name="gambarLama" value="<?= $barang['gambar']; ?>">
                <div class="form-group">
                    <label for="nama">
                        Nama Produk
                    </label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" autofocus value="<?= (old('nama')) ? old('nama') : $barang['nama']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deksripsi">
                        Deskripsi Produk
                    </label>
                    <input type="text" class="form-control" name="deskripsi" value="<?= (old('deskripsi')) ? old('deskripsi') : $barang['deskripsi']; ?>">
                </div>
                <div class="form-group">
                    <label for="gambar">Foto Produk</label>
                    <input type="file" class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" name="gambar" placeholder="<?= $barang['gambar']; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('gambar'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Update Produk</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>