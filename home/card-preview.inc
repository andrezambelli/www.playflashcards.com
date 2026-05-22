<?php /** @var array $t */ ?>
<section class="pb-5 overflow-hidden">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-11 col-md-9 col-lg-7">
                <div class="car-card-stack">
                    <div class="car-card-ghost car-card-ghost--back"></div>
                    <div class="car-card-preview">
                        <div class="car-card-preview-header">
                            <span class="car-label-uc">
                                <?= car_t($t, 'Front') ?> &middot; 7/20
                            </span>
                        </div>
                        <div class="car-card-preview-body">
                            <p class="car-card-preview-text mb-0">Posh part of the city</p>
                        </div>
                        <div class="car-card-preview-footer">
                            <span class="car-card-preview-hint"><?= car_t($t, 'home.hero.card-hint') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
