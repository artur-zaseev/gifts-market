var mapCenter = {lat: 59.960786, lng: 30.285902};
var places = [
  {
    lat: 59.960661, 
    lng: 30.280098,
    name: "ул. Красного курсанта 25, лит. Д"
  }
];

function initMap() 
{
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 14,
    center: mapCenter,
    disableDefaultUI: true,
    styles: [{"stylers": [{"hue": "#2c3e50"}, {"saturation": 250 } ] }, {"featureType": "road", "elementType": "geometry", "stylers": [{"lightness": 50 }, {"visibility": "simplified"} ] }, {"featureType": "road", "elementType": "labels", "stylers": [{"visibility": "off"} ] } ]
  });

  var flightPlanCoordinates = [
    {lat: 59.961063, lng: 30.292019},
    {lat: 59.961469, lng: 30.291823},
    {lat: 59.963111, lng: 30.288660},
    {lat: 59.962283, lng: 30.284397},
    {lat: 59.962050, lng: 30.283010},
    {lat: 59.961533, lng: 30.280237},
    {lat: 59.961248, lng: 30.279444},
    {lat: 59.961081, lng: 30.279057},
    {lat: 59.960688, lng: 30.280094}
  ];
  var lineSymbol = {
    path: 'M 0,0 0,0',
    strokeOpacity: 1,
    scale: 4
  };
  var flightPath = new google.maps.Polyline({
    path: flightPlanCoordinates,
    geodesic: true,
    strokeColor: '#2a62d3',
    strokeOpacity: 0,
    strokeWeight: 2,
    icons: [{
      icon: lineSymbol,
      offset: '0',
      repeat: '10px'
    }]
  });

  flightPath.setMap(map);

  places.forEach(function(element) {

  	var icon = {
    	url: "/assets/img/template/map_point.svg",
    	scaledSize: new google.maps.Size(30, 30)
 		};

    var marker = new google.maps.Marker({
      position: {lat: element.lat, lng: element.lng},
      map: map,
      icon: icon
    });

    var infowindow = new google.maps.InfoWindow({
      content: element.name
    });

    marker.addListener('click', function() {
      infowindow.open(map, marker);
    });
  });
}