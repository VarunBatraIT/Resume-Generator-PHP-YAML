<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <img class="img-responsive center-block img-circle" src="https://s.gravatar.com/avatar/<?= $profile['gravatar'] ?>?s=80" alt=""/>

                <h1><?= $profile['name'] ?></h1>
                <h4><?= $profile['role'] ?></h4>
                <?= $profile['address'] ?>
            </div>
            <div class="col-md-3">
                <h3>Social</h3>
                <?= parse_resume($profile['social']) ?>
            </div>
            <div class="col-md-3">
                <h3>Contact</h3>
                <?= parse_resume($profile['links']) ?>
            </div>
        </div>
        <hr/>
        <div class="row col-md-12">
            <?= parse_resume($resume); ?>

        </div>
    </div>
</main>
