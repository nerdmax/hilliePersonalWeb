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



    var roadAtlasStyles = [{"featureType":"all","elementType":"geometry.fill","stylers":[{"weight":"2.00"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"color":"#9c9c9c"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#eeeeee"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#7b7b7b"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c8d7d4"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#070707"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]}];



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
