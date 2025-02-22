<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">Livrez toujours plus que prévu.</h1>
        <p class="btn btn-primary my-2">Vous devez avoir des habitudes saines,avec un mode de vie sain pendant la journée.</p>
    </div>
</section>


<div class="album py-5 bg-light">
    <div class="container">

        <div class="row">

            <?php foreach ($products as $p) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 box-shadow">
                        <img class="card-img-top" src="./uploads/<?= $p['filename']; ?>">
                        <div class="card-body">
                            <p class="card-text"><?= $p['name']; ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="/index.php/product?id=<?= $p['id']; ?>" class="btn btn-sm btn-outline-secondary">Voir</a>
                                </div>
                                <small class="text-muted"><?= $p['price']; ?>€</small>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>
</div>
