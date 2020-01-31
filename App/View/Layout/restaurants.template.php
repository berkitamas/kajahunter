<div id="restaurants-wrapper" class="wrapper">
    <h2>Éttermek</h2>
    <table id="restaurants">
        <thead>
            <tr>
                <th colspan="2">Adatok</th>
                <th>Kiszállítási idő</th>
                <th class="opening" colspan="2">Nyitvatartás</th>
                <th></th>
            </tr>
        </thead>
        <tbody><?php foreach($restaurants as $restaurant) { ?>
            <tr>
                <td class="logo"><img src="<?=($restaurant["logo_file"])?"/uploads/".$restaurant["logo_file"]:"/assets/img/default-restaurant-logo.png"?>" alt="<?=$restaurant["company_name"]?>"></td>
                <td class="details">
                    <h3 class="title"><?=$restaurant["company_name"]?></h3>
                    <?php if ($restaurant["cuisine"]) {?>
                    <p class="cuisine"><?=$restaurant["cuisine"]?></p>
                    <?php } ?>
                </td>
                <td class="delivery_time"><?=($restaurant["delivery_time"])?$restaurant["delivery_time"]:"Ismeretlen"?></td>
                <?php if ($restaurant["nonstop"]) {
                    echo "<td class=\"nonstop\" colspan=\"2\"><p>Éjjel-nappali</p></td>";
                } else {
                    if ($restaurant["opened"]) {
                        echo '<td class="opening-current open"><p class="open">Nyitva</p></td>';
                    } else {
                        echo '<td class="opening-current close"><p class="close">Zárva</p></td>';
                    }?>
                <td class="opening-hours">
                    <p class="open"><?=$restaurant["parsed_from"]?></p>
                    <p class="close"><?=$restaurant["parsed_to"]?></p>
                </td>
                <?php } ?>
                <td class="menu">
                    <a href="etterem/<?=$restaurant["id"]?>" class="button-view"><span>Étlap</span></a>
                </td>
            </tr>
        <?php } ?></tbody>
    </table>
</div> <!-- /#restaurants-wrapper -->
