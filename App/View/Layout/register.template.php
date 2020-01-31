<div id="registerpanel">
    <h2>Regisztráció</h2>
    <div id="notify">
        <?php if($errors && count($errors) > 0) foreach ($errors as $error) { ?>
            <div class="notice"><?=$error?></div><!-- /.notice -->
        <?php } ?></div><!-- /.notify -->
    <ul class="tab">
        <li class="<?=($is_company)?"":"selected "?>noselect">Fogyasztó</li>
        <li class="<?=($is_company)?"selected ":""?>noselect">Étterem</li>
    </ul>
    <form method="post" id="register">
        <input type="hidden" id="token" name="token" value="<?=$token?>">
        <input type="hidden" name="regtype" id="regtype" value="<?=($is_company)?1:0?>">
        <div class="<?=($is_company)?"switched ":""?>fields">
            <div class="person">
                <div class="field required">
                    <input type="email" name="p_email" id="p_email"<?=($p_email)?' value='.$p_email:""?>>
                    <label for="p_email" class="placeholder noselect"><span class="text">E-mail cím</span></label>
                    <span class="help">Pl.: kisspista@email.hu</span>
                </div><!-- /.field -->
                <div class="field required">
                    <div class="half">
                        <input type="text" name="p_lname" id="p_lname"<?=($p_lname)?' value='.$p_lname:""?>>
                        <label for="p_lname" class="placeholder noselect"><span class="text">Vezetéknév</span></label>
                        <span class="help">Pl.: Kiss</span>
                    </div><!-- /.half -->
                    <div class="half">
                        <input type="text" name="p_fname" id="p_fname"<?=($p_fname)?' value='.$p_fname:""?>>
                        <label for="p_fname" class="placeholder noselect"><span class="text">Keresztnév</span></label>
                        <span class="help">Pl.: István</span>
                    </div><!-- /.half -->
                </div><!-- /.field -->
                <div class="sep"></div><!-- /.sep -->
                <div class="field required">
                    <input type="password" name="p_password" id="p_password">
                    <label for="p_password" class="placeholder noselect"><span class="text">Jelszó</span></label>
                    <span class="help password"></span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="password" name="p_password_again" id="p_password_again">
                    <label for="p_password_again" class="placeholder noselect"><span class="text">Jelszó újra</span></label>
                    <span class="help password"></span>
                </div><!-- /.field -->
                <div class="sep"></div><!-- /.sep -->
                <div class="field required">
                    <input type="text" name="p_postcode" id="p_postcode"<?=($p_postcode)?' value='.$p_postcode:""?>>
                    <label for="p_postcode" class="placeholder noselect"><span class="text">Irányítószám</span></label>
                    <span class="help">Pl.: 6725</span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="text" name="p_city" id="p_city"<?=($p_city)?' value='.$p_city:""?>>
                    <label for="p_city" class="placeholder noselect"><span class="text">Város</span></label>
                    <span class="help">Pl.: Szeged</span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="text" name="p_street" id="p_street"<?=($p_street)?' value='.$p_street:""?>>
                    <label for="p_street" class="placeholder noselect"><span class="text">Utca</span></label>
                    <span class="help">Pl.: Fő utca</span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="text" name="p_address" id="p_address"<?=($p_address)?' value='.$p_address:""?>>
                    <label for="p_address" class="placeholder noselect"><span class="text">Házszám</span></label>
                    <span class="help">Pl.: 20. 1. em 10. a.</span>
                </div><!-- /.field -->
                <div class="sep"></div><!-- /.sep -->
                <div class="field required">
                    <input type="tel" name="p_phone" id="p_phone"<?=($p_phone)?' value='.$p_phone:""?>>
                    <label for="p_phone" class="placeholder noselect"><span class="text">Telefonszám</span></label>
                    <span class="help">Pl.: +36201122334</span>
                </div><!-- /.field -->
                <div class="field">
                    <h3>Születési dátum</h3>
                    <div class="date year">
                        <input type="text" name="p_byear" pattern="\d*" maxlength="4" id="p_byear"<?=($p_byear)?' value='.$p_byear:""?>>
                        <label for="p_byear" class="placeholder noselect"><span class="text">Év</span></label>
                        <span class="help">Pl.: 1970</span>
                    </div><!-- /.date.year -->
                    <div class="date month">
                        <div class="select month">
                            <select name="p_bmonth" id="p_bmonth">
                                <option disabled<?=(!$p_bmonth)?" selected":""?>>Hónap</option>
                                <option value="1"<?=($p_bmonth && $p_bmonth == 1)?" selected":""?>>Január</option>
                                <option value="2"<?=($p_bmonth && $p_bmonth == 2)?" selected":""?>>Február</option>
                                <option value="3"<?=($p_bmonth && $p_bmonth == 3)?" selected":""?>>Március</option>
                                <option value="4"<?=($p_bmonth && $p_bmonth == 4)?" selected":""?>>Április</option>
                                <option value="5"<?=($p_bmonth && $p_bmonth == 5)?" selected":""?>>Május</option>
                                <option value="6"<?=($p_bmonth && $p_bmonth == 6)?" selected":""?>>Június</option>
                                <option value="7"<?=($p_bmonth && $p_bmonth == 7)?" selected":""?>>Július</option>
                                <option value="8"<?=($p_bmonth && $p_bmonth == 8)?" selected":""?>>Augusztus</option>
                                <option value="9"<?=($p_bmonth && $p_bmonth == 9)?" selected":""?>>Szeptember</option>
                                <option value="10"<?=($p_bmonth && $p_bmonth == 10)?" selected":""?>>Október</option>
                                <option value="11"<?=($p_bmonth && $p_bmonth == 11)?" selected":""?>>November</option>
                                <option value="12"<?=($p_bmonth && $p_bmonth == 12)?" selected":""?>>December</option>
                            </select>
                            <div class="selectarrow"><i class="fa fa-chevron-down"></i></div>
                        </div><!-- /.select.month -->
                        <label for="p_bmonth" class="placeholder noselect"><span class="text">Hónap</span></label>
                        <span class="help">Pl.: Február</span>
                    </div><!-- /.date.month -->
                    <div class="date day">
                        <input type="text" name="p_bday" pattern="\d*" maxlength="2" id="p_bday"<?=($p_bday)?' value='.$p_bday:""?>>
                        <label for="p_bday" class="placeholder noselect"><span class="text">Nap</span></label>
                        <span class="help">Pl.: 12</span>
                    </div>
                    <!-- /.date.day -->
                </div><!-- /.field -->
                <div class="field">
                    <input type="checkbox" name="p_acceptterm" id="p_acceptterm"><label for="p_acceptterm"><span><i class="fa fa-check"></i></span>Elfogadom a KajaHunter Kft. <a target="_blank" href="<?=\App\Settings::get("base")?>adatvedelem/">adatvédelmi feltételeit.</a></label><br />
                </div><!-- /.field -->
            </div><!-- /.person -->
            <div class="company">
                <div class="field required">
                    <input type="email" name="c_email" id="c_email"<?=($c_email)?' value='.$c_email:""?>>
                    <label for="c_email" class="placeholder noselect"><span class="text">E-mail cím</span></label>
                    <span class="help">Pl.: contact@seholsincsceg.hu</span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="text" name="c_cname" id="c_cname"<?=($c_cname)?' value='.$c_cname:""?>>
                    <label for="c_cname" class="placeholder noselect"><span class="text">Étterem neve</span></label>
                    <span class="help">Pl.: Seholsincs Étterem</span>
                </div><!-- /.field -->
                <div class="sep"></div>
                <div class="field required">
                    <input type="password" name="c_password" id="c_password">
                    <label for="c_password" class="placeholder noselect"><span class="text">Jelszó</span></label>
                    <span class="help password"></span>
                </div><!-- /.field -->
                <div class="field required">
                    <input type="password" name="c_password_again" id="c_password_again">
                    <label for="c_password_again" class="placeholder noselect"><span class="text">Jelszó újra</span></label>
                    <span class="help password"></span>
                </div><!-- /.field -->
                <div class="sep"></div><!-- /.sep -->
                <div class="field required">
                    <input type="tel" name="c_phone" id="c_phone"<?=($c_phone)?' value='.$c_phone:""?>>
                    <label for="c_phone" class="placeholder noselect"><span class="text">Telefonszám</span></label>
                    <span class="help">Pl.: +36201122334</span>
                </div><!-- /.field -->
                <div class="sep"></div><!-- /.sep -->
                <div class="field">
                    <input type="text" name="c_postcode" id="c_postcode"<?=($c_postcode)?' value='.$c_postcode:""?>>
                    <label for="c_postcode" class="placeholder noselect"><span class="text">Irányítószám</span></label>
                    <span class="help">Pl.: 6725</span>
                </div><!-- /.field -->
                <div class="field">
                    <input type="text" name="c_city" id="c_city"<?=($c_city)?' value='.$c_city:""?>>
                    <label for="c_city" class="placeholder noselect"><span class="text">Város</span></label>
                    <span class="help">Pl.: Szeged</span>
                </div><!-- /.field -->
                <div class="field">
                    <input type="text" name="c_street" id="c_street"<?=($c_street)?' value='.$c_street:""?>>
                    <label for="c_street" class="placeholder noselect"><span class="text">Utca</span></label>
                    <span class="help">Pl.: Fő utca</span>
                </div><!-- /.field -->
                <div class="field">
                    <input type="text" name="c_address" id="c_address"<?=($c_address)?' value='.$c_address:""?>>
                    <label for="c_address" class="placeholder noselect"><span class="text">Házszám</span></label>
                    <span class="help">Pl.: 20. 1. em 10. a.</span>
                </div><!-- /.field -->
                <div class="sep"></div>
                <div class="field">
                    <input type="checkbox" name="c_acceptterm" id="c_acceptterm"><label for="c_acceptterm"><span><i class="fa fa-check"></i></span>Elfogadom a KajaHunter Kft. <a target="_blank" href="<?=\App\Settings::get("base")?>adatvedelem/">adatvédelmi feltételeit.</a></label><br />
                </div><!-- /.field -->
            </div><!-- /.company -->
            <div class="sep"></div><!-- /.sep -->
            <div class="field">
                <input type="submit" value="Regisztráció">
            </div><!-- /.field -->
        </div><!-- /.fields -->
    </form>
</div><!-- /#registerpanel -->
