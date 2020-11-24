<?= $this->extend('layout/template'); ?>

<?= $this->section('content') ?>
<div class="container">
    <h2 class="text-center my-5">Daftar Produk</h2>
    <div class="row">
        <div class="col-8">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"><?= session()->getFlashdata('pesan'); ?></h6>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php foreach ($barang as $b) : ?>
                    <div class="col-sm-3">
                        <div class="card m-b-30">
                            <img class="card-img-top img-fluid" src="/asset/img/<?= $b['gambar']; ?>" alt="Card image cap">
                            <div class="card-body">
                                <h4 class="card-title font-20 mt-0"><?= $b['nama']; ?></h4>
                                <p class="card-text">Some quick example text to build on the card title and make
                                    up the bulk of the card's content.</p>
                                <a href="/admin/view/<?= $b['slug']; ?>" class="btn btn-primary waves-effect waves-light">Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>