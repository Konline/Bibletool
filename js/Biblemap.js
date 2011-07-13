// Class in charge of biblemap section
var Biblemap = {
  // Populate the bible places pull down menu and display the map for
  // the 1st entry in the pull down menu
  // Parameters:
  // - url: URL that will return the JSON representing all the bible places
  biblemap: function(url) {
    $("#biblemap-select").empty();
    var jqxhr = $.getJSON(url, function(data) {
      // data is a hash that looks like:
      // {
      //   "Leshem": {
      //   "chinese_name": "åˆ©å–„", 
      //   "lat": "33.248659",
      //   "lon": "35.652483", 
      //   "notes": "Now Tel Dan",
      //   "verses": [
      //       "JOS 19:47"
      //   ],
      //   (...other places...)
      // }
      for (var place in data) {
        $("<option value='" + $.toJSON(data[place]) + "'>" +
          place + " (" + data[place].chinese_name + ")</option>")
          .appendTo($("#biblemap-select"));
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#biblemap-body');
      })
      .complete(function() {
        // use URL hash to implement bookmarking
        // we bind at this stage because hashchange callback requires
        // a fully populated pull down menu
        $(window).bind( 'hashchange', function(e) {
          console.log('in hashchange evt...');
          // the URL is the string after the hash mark, called the
          // 'fragment' below. 
          var fragment = $.param.fragment();
          if ( fragment == "" ) {
            // there is no fragment, do nothing
            // do not attempt to update the URI here because
            // the places pull down menu may not have been initialized yet
          } else {
            var place = fragment.match(/(\S+)/)[1];
            // make this place selected
            $("#biblemap-select option").removeAttr('selected');
            var option = $("#biblemap-select option:contains('" + fragment + " ')");
            console.log(option);
            /*

              var option = $("#biblemap-select option:selected");
              var value = $.parseJSON(option.val());
              var name = option[0].text;
              var lat = value.lat;
              var lon = value.lon;
              var notes = value.notes;
              var verses = value.verses;
              var link = $.map(verses, function(v, i) {
              return v.replace(/ /, ":");
              }).join(";");
              $("#map_node").remove();
              // Build a map_node div that looks like this:
              // <div id="map_node">
              //   <div class="bible-map-name">Leshem 利善</div>
              //   <div class="bible-map-notes">Now Tel Dan</div>
              //   <div class="bible-map-verses">
              //     <a href="/browse#UCV:JOS:19:47">JOS 19:47</a>
              //   </div>
              // </div>
              $("<div id=map_node></div>").appendTo("#biblemap-body");
              $("<div class=bible-map-name>" + name + "</div>").appendTo($("#map_node"));
              $("<div class=bible-map-notes>" + notes + "</div>").appendTo($("#map_node"));
              $("<div class=bible-map-verses>" + 
              "<a href=" + webroot + "/browse#UCV:" + link + ">" +
              verses + "</a></div>").appendTo($("#map_node"));
              Biblemap.initializeMap(lat, lon);
              // unrecognized hash
              */
          }
        });
        
        // trigger the hashchange by default
        $(window).trigger( 'hashchange' );
      });
  },
  
  // Call Google Map API and pass the 'map_canvas' div
  // Parameters:
  // - lat: float representing the location latitude
  // - lng: float representing the location longitude
  initializeMap: function (lat, lng) {
    var map = new google.maps.Map2(document.getElementById('map_canvas'));
    var latlng = new google.maps.LatLng(lat, lng);
    var mapNode = document.getElementById('map_node');
    // Function to create a marker on the map
    // Parameters:
    // - latlng: A google.maps.LatLng object containing the place coordinates
    function createMarker(latlng) {
      var marker = new GMarker(latlng);
      GEvent.addListener(marker, 'click', function () {
        map.openInfoWindow(latlng, mapNode);
      });
      return marker;
    };
    map.setCenter(latlng, 5);
    map.setUIToDefault();
    map.setMapType(G_HYBRID_MAP);
    map.addOverlay(createMarker(latlng));
    map.openInfoWindow(latlng, mapNode);
  }
};

$(document).ready(function() {
  // Populate the pull down menu and setup the necessary hashevent callbacks
  Biblemap.biblemap(webroot + '/biblemap/index');

  // Update the place when user changes the select menu
  // We use the english name as the keyword
  $("#biblemap-select").change(function() {
    var option = $("#biblemap-select option:selected");
    var english = option[0].text.match(/(\S+)/)[1];
    window.location.hash = english;
  });
});



