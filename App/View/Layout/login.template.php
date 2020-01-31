<div id="loginpanel">
    <h2>Bejelentkezés</h2>
    <div id="notify">
        <?php
        if($message) {
			echo '<div class="notice green">' . $message . '</div><!-- /.notice -->';
		}

        if($errors && count($errors) > 0) foreach ($errors as $error) {
            echo '<div class="notice">' . $error . '</div><!-- /.notice -->';
        }
        ?>
    </div><!-- /.notify -->
    <form method="post" id="login">
        <input type="hidden" id="token" name="token" value="<?=$token?>">
        <div class="fields">
            <div class="field">
                <div class="icon"><i class="fa fa-user"></i>
                </div>
                <input type="email" placeholder="E-mail cím" name="email" required>
            </div><!-- /.field -->
            <div class="field">
                <div class="icon"><i class="fa fa-key"></i></div>
                <input type="password" placeholder="Jelszó" name="password" required>
            </div><!-- /.field -->
            <input type="checkbox" name="rememberme" id="rememberme"><label for="rememberme"><span><i class="fa fa-check"></i></span>Jegyezzen meg</label><br />
            <a href="<?=\App\Settings::get("base")?>regisztracio/" class="ajax">Nincs még azonosítója? Regisztráljon!</a><br />
            <a href="<?=\App\Settings::get("base")?>elfelejtettjelszo/" class="ajax">Elfelejtette jelszavát?</a>
            <input type="submit" value="Bejelentkezés">
        </div><!-- /.fields -->
    </form>
</div><!-- /#loginpanel -->
