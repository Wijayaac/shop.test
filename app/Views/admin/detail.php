<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <div class="card text-center mx-auto">
                <div class="card-body mx-auto">
                    <h4 class="card-title text-center"><?= $barang['nama']; ?></h4>
                    <img src="<?= base_url('asset/img'); ?>/<?= $barang['gambar']; ?>" class="w-25" alt="">
                </div>
                <div class="card-body">
                    <p class="card-text"><?= $barang['deskripsi']; ?></p>
                </div>
            </div>
            <a href="/admin/view" class="btn btn-primary">Kembali <i class="fa fa-home" aria-hidden="true"></i></a>
            <a href="/admin/edit/<?= $barang['slug']; ?>" class="btn btn-warning">Edit <i class="fas fa-edit"></i></a>
            <form action="/admin/view/<?= $barang['idBarang']; ?>" method="POST" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="btn btn-danger">Hapus <i class="fa fa-trash" aria-hidden="true"></i></button>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>