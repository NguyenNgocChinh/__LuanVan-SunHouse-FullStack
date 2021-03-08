// Create the script tag, set the appropriate attributes
var script = document.createElement('script');
script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyAVQEAPAglsyD2w7rWppn2Te21X5rWrMo4&callback=initMap';
script.defer = true;

// Attach your callback function to the `window` object
window.initMap = function() {
  // JS API is loaded and available
    const myLocation = { lat: 10.738150, lng: 106.677850 };
     var option = {
        zoom: 16,
         center: myLocation,
        // gestureHandling: "cooperative",
         gestureHandling: 'greedy',
         scrollwheel: false
    }
    var map = new google.maps.Map(document.getElementById("map"), option);
    
    //list markers
    var features = [
          {
            position:new google.maps.LatLng(10.738150,106.677850),
            type: 'info'
          }, {
            position: new google.maps.LatLng(10.738900,106.679950),
            type: 'info'
          },
          {
            position: new google.maps.LatLng(10.739000,106.675050),
            type: 'info'
          },
        ];

    // Create markers.
    for (var i = 0; i < features.length; i++) {
        var marker = new google.maps.Marker({
            position: features[i].position,
            // icon: icons[feature.type].icon,
            map: map
        });

        //Hover marker
        marker.addListener('mouseover', function() {
            this.setOpacity(0.5);
        });
        marker.addListener('mouseout', function() {
            this.setOpacity(1);
        });
    };
};

// Append the 'script' element to 'head'
document.head.appendChild(script);

