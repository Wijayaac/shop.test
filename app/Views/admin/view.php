<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"><?= session()->getFlashdata('pesan'); ?></h6>
                </div>
            <?php endif; ?>
            <h2 class="text-center my-5">Daftar Produk</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th>Nama Produk</th>
                        <th>Aksi</th>
                        <th>Foto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $b) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></td>
                            <td><?= $b['nama']; ?></td>
                            <td><a class="btn btn-info btn-sm " href="/admin/view/<?= $b['slug']; ?>" role="button">Detail </a></td>
                            <td><img src="/asset/img/<?= $b['gambar']; ?>" class="img-fluid w-25 sampul" alt=""></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>