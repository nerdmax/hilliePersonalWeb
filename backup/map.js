<!-- ================================================== -->

<!-- =============== START GOOGLE MAP SETTINGS ================ -->

<!-- ================================================== -->



jQuery(document).ready(function(){



  var map;

  var lat = jQuery('#map-canvas').data('lat');

  var long = jQuery('#map-canvas').data('long');

  var myLatLng = new google.maps.LatLng(lat,long);

  var title = jQuery('#map-canvas').data('title')

  var description = jQuery('#map-canvas').data('description')



  function initialize() {



    var roadAtlasStyles = [

      {

        stylers: [

          { hue: "#00ffe6" },

          { saturation: -20 }

        ]

      },{

        featureType: "road",

        elementType: "geometry",

        stylers: [

          { lightness: 100 },

          { visibility: "simplified" }

        ]

      },{

        featureType: "road",

        elementType: "labels",

        stylers: [

          { visibility: "off" }

        ]

      }

    ];



    var mapOptions = {

        zoom: 13,

      center: myLatLng,

  	disableDefaultUI: true,

  	scrollwheel: false,

      navigationControl: false,

      mapTypeControl: false,

      scaleControl: false,

      draggable: false,

      mapTypeControlOptions: {

        mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'usroadatlas']

      }

    };



    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);



    var img = jQuery('#map-canvas').data('img');

     

    var marker = new google.maps.Marker({

        position: myLatLng,

        map: map,

        icon: img,

  	  title: ''

    });

    

    var contentString = '<div style="max-width: 300px" id="content">'+

        '<div id="bodyContent">'+

  	  '<h5 class="color-primary"><strong>'+ title +'</strong></h5>' +

        '<p style="font-size: 12px">' + description + '</p>'+

        '</div>'+

        '</div>';



    var infowindow = new google.maps.InfoWindow({

        content: contentString

    });

    

    google.maps.event.addListener(marker, 'click', function() {

      infowindow.open(map,marker);

    });



    var styledMapOptions = {

      name: 'US Road Atlas'

    };



    var usRoadMapType = new google.maps.StyledMapType(

        roadAtlasStyles, styledMapOptions);



    map.mapTypes.set('usroadatlas', usRoadMapType);

    map.setMapTypeId('usroadatlas');

  }



  google.maps.event.addDomListener(window, 'load', initialize);

    

});



<!-- ================================================== -->

<!-- =============== END GOOGLE MAP SETTINGS ================ -->

<!-- ================================================== -->
