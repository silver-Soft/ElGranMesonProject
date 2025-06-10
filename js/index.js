/* MAP CANVAS*/
function initialize() {
    var lat = 19.468721;
    var lon = -97.926971;
    var myLatLng = new google.maps.LatLng(lat, lon);
    var mapOptions = {
      zoom: 19,
      center: myLatLng,
      mapTypeId: google.maps.MapTypeId.SATELLITE,
      disableDefaultUI: true,
      zoomControl: true,
      mapTypeControl: true,
      scaleControl: false,
      streetViewControl: false,
      rotateControl: true,
      fullscreenControl: false,
    };
      
    var map = new google.maps.Map(
      document.getElementById("map-canvas"),
      mapOptions
    );

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: "Ubicación central",
        icon: {
          //url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
          url: "/ElGranMesonProject/img/alfiler.png", // Reemplaza por tu URL o ruta local
          scaledSize: new google.maps.Size(40, 40) // Ajusta tamaño si es necesario
        }
      });
      //C:\xampp\htdocs\ElGranMesonProject\img\alfiler.png
}