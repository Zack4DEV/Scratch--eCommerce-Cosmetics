<div class="album py-5 bg-light">
    <div class="container">

        <div class="row">
            <h1>Ajouter un Produit</h1>
            <div class="col-lg-12">
                <form method="POST" name="product" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="textarea" class="form-control" name="description">
                    </div>
                    <div class="form-group">
                        <label for="price">Prix</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="form-group">
                        <label for="file">Logo</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                    <div class="form-group">
                        <label for="category">Catégorie</label>
                        <select class="form-control" name="category">
                            <?php 
foreach ($categories as $c) { 
                                    echo "<option value=" .  $c['id'] . ">". $c['name'] . "</option>";
                                } 
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </form>
            </div>
        </div>
    </div>
</div>
