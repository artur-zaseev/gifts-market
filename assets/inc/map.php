<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
<script type="text/javascript">
	var map;
	DG.then(function () {
		map = DG.map('map', {
			center: [59.960809, 30.280203],
			zoom: 15
		});
		DG.marker([59.960809, 30.280203]).addTo(map).bindPopup('«GIFTY.ONE»<br>Красного курсанта 25Д&nbsp;&nbsp;&nbsp;');
	});
</script>
<div id="map" style="width:100%; height:260px"></div>