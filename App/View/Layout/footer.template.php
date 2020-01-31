        </main>
        <footer>
            <div class="box">
                <div class="wrapper">
                    <div class="facebook">
                        <div class="inner">
                            <img src="http://via.placeholder.com/800x260?text=Facebook" width="400" height="130" alt="Facebook">
                        </div><!-- /.inner -->
                    </div><!-- /.facebook -->
                    <div class="links">
                        <ul>
                            <li><a href="<?=\App\Settings::get("base")?>adatvedelem">Adatvédelmi feltételek</a></li>
                            <li><a href="<?=\App\Settings::get("base")?>sutik">Cookie-kal kapcsolatos irányelvek</a></li>
                        </ul>
                    </div><!-- /.links -->
                </div><!-- /.wrapper -->
            </div><!-- / .box -->
            <div class="copyright">
                <div class="wrapper">&copy; 2018 Berki Tamás (PDRE31)</div><!-- ./wrapper -->
            </div><!-- /.copyright -->
        </footer>
    </div><!-- /#container -->
    <script>
        //Mobilon a hover és active miatt
        document.body.addEventListener('touchstart',function(){},false);
    </script>
</body>
</html>