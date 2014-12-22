<main>
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center">
                <img src="https://s.gravatar.com/avatar/<?= $profile['gravatar'] ?>?s=300" alt=""/>

            </div>
            <div class="col-md-6">
                <div class="text-center">
                    <h1><?= $profile['name'] ?></h1>
                    <h4><?= $profile['role'] ?></h4>
                    <?= $profile['address'] ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <h3>Social</h3>
                            <?= parse_resume($profile['social']) ?>
                        </div>
                        <div class="col-md-6">
                            <h3>Contact</h3>
                            <?= parse_resume($profile['links']) ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <hr/>
        <div class="row col-md-12">
            <?= parse_resume($resume); ?>

        </div>
    </div>
</main>
