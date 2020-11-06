<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-5"> Form Tambah data Produk</h2>
            <form action="/admin/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama">
                        Nama Produk
                    </label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" id="" aria-describedby="emailHelpId" placeholder="masukkan nama produk..." autofocus value="<?= old('nama'); ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deksripsi">
                        Deskripsi Produk
                    </label>
                    <input type="text" class="form-control" name="deskripsi" id="" aria-describedby="emailHelpId" placeholder="masukkan deksripsi produk" required value="<?= old('deskripsi'); ?>">
                </div>
                <div class="form-group">
                    <label for="gambar">Foto Produk</label>
                    <input type="file" class="form-control <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" name="gambar" id="gambar" placeholder="pilih gambar">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-primary">Tambah Produk</button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>