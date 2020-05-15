</div>
<!-- /Wrapper -->

<!-- FOOTER -->
<?php 
	if ( $footer_hide_line_on_top === true )	{
		echo '<footer class="footer footer_hideLineOnTop">';
	} else {
		echo '<footer class="footer">';
	}
?>
	<div class="container">
		<div class="row align-items-center">
			<div class="col-2">
				<a href="/" class="logo">
					<img src="/assets/img/template/logogifty_blue.svg">
				</a>
			</div>
			<div class="col-5 offset-2">
				<p><a href="tel:+78005057195" class="js_set_phone_href">8 (800) 505-71-95</a></p>
				<p><a href="mailto:main@gifty.one">main@gifty.one</a></p>
				<p>Санкт-Петербург, ул. Красного Курсанта 25Д</p>
			</div>
			<div class="col-3 text-right footer_links">
				<p class="bold"><a href="/blog.php">Блог</a></p>
				<p class="bold"><a href="/delivery.php">Доставка</a></p>
				<p class="bold"><a href="/contacts.php">Контакты</a></p>
				<p class="bold"><a href="/print.php">Виды печати</a></p>
			</div>
		</div>
	</div>

<?php echo '</footer>';   ?>

<!-- /FOOTER -->

<!-- Попап Mini-->
<div class="popup" style="display: none;"></div>
<!-- /Попап Mini-->

<script type="text/javascript" src="/assets/js/jquery-2.2.1.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/modules/magnific-popup/jquery.magnific-popup.js"></script>
<script type="text/javascript" src="/assets/modules/slick/slick.js"></script>
<script type="text/javascript" src="/assets/js/functions.js<?php echo "?".rand(0, 999999); ?>"></script>
<script type="text/javascript" src="/assets/js/events.js<?php echo "?".rand(0, 999999); ?>"></script>
<!-- <script type="text/javascript" src="/assets/js/dev.js"></script> -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

   ym(52551871, "init", {
        id:52551871,
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
   });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/52551871" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


</body>

</html>