<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h4 class="my-4">Form Tambah Data Barang.</h4>
            <form action="/admin/save" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="nama">Nama Produk</label>
                    <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" name="nama" value="<?= old('nama'); ?> " autofocus required>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nama'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="deskripsi"> Deskripsi</label>
                    <input type="text" class="form-control" name="bio" value="<?= old('deskripsi'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control-file <?= ($validation->hasError('gambar')) ? 'is-invalid' : ''; ?>" name="gambar">
                    <div class="invalid-feedback">
                        <?= $validation->getError('gambar'); ?>
                    </div>
                </div>
                <a class="btn btn-success btn-sm " href="#" role="button" type="submit"> </a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>