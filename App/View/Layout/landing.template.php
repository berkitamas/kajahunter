<div id="landing-overlay" class="overlay-image">
    <h2>Szia! Mit szeretnél <?php
        if ($part_of_day == 2) {
            echo "vacsorázni";
        }
        elseif ($part_of_day == 1) {
            echo "ebédelni";
        } else {
            echo "reggelizni";
        }
    ?>?</h2>
</div><!-- /#landing-overlay -->
<div id="landing-wrapper" class="wrapper">
    <h2 class="font-light">Legnépszerűbb éttermeink</h2>
    <div id="favourite-restaurants"><!--
        <?php foreach ($restaurants as $restaurant) {?>
        --><div class="card">
            <div class="cover" style="background-image: url('<?php
                if ($restaurant["cover_file"]) {
                    echo \App\Settings::get("base") . "uploads/" . $restaurant["cover_file"];
                } else {
                    echo  \App\Settings::get("base")  . "assets/img/default-cover.jpg";
                } ?>')">
                <h3 class="title"><?=$restaurant["company_name"]?></h3>
            </div><!-- /.cover -->
            <div class="desc">
                <ul>
                    <?php if ($restaurant["cuisine"]) {
                        ?><li><i class="fa fa-cutlery"></i> <?=$restaurant["cuisine"]?></li>
                    <?php } ?>
                    <?php if ($restaurant["postcode"] && $restaurant["city"] && $restaurant["street"] && $restaurant["address"]) {
                        ?><li><i class="fa fa-location-arrow"></i> <?=$restaurant["postcode"]?> <?=$restaurant["city"]?>, <?=$restaurant["street"]?> <?=$restaurant["address"]?></li>
                    <?php } ?>
                    <?php if ($restaurant["delivery_time"]) {
                        ?><li><i class="fa fa-truck"></i> <?=$restaurant["delivery_time"]?></li>
                    <?php } ?>
                    <li><i class="fa fa-clock-o"></i> <?php
                        if ($restaurant["nonstop"]) {
                            echo "Éjjel-Nappali";
                        } else {
                            echo $restaurant["parsed_from"] . " - " . $restaurant["parsed_to"];
                        }
                        ?></li>
                </ul>
            </div><!-- /.desc -->
            <div class="view"><a href="<?=\App\Settings::get("base")?>etterem/<?=$restaurant["id"]?>" class="button-view"><span>Megnézem</span></a></div><!-- /.view -->
        </div><!-- /.card --><!--
        <?php } ?>-->
    </div>
    <!-- /#favourite-restaurants -->
</div><!-- /#landing-wrapper -->
