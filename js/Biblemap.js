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
          place + " " + data[place].chinese_name + "</option>")
          .appendTo($("#biblemap-select"));
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#biblemap-body');
      })
      .complete(function (){
        // make the first element selected
        $("biblemap-select option").first().attr("selected", "selected");
        // trigger the change event
        $("#biblemap-select").change();
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
  // Update the place when user changes the select menu
  $("#biblemap-select").change(function() {
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
  });
  // Load the JSON data from the server
  Biblemap.biblemap(webroot + '/biblemap/index');
});


                  
