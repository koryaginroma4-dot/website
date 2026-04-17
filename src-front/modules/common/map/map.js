// assets/js/map.js
window.initMap = function() {
  console.log('initMap called');
  
  const mapContainers = document.querySelectorAll('.map-container');
  console.log('Found containers:', mapContainers.length);
  
  mapContainers.forEach((container, index) => {
    const lat = parseFloat(container.dataset.mapLat);
    const lng = parseFloat(container.dataset.mapLng);
    const zoom = parseInt(container.dataset.mapZoom);
    
    // Ищем элемент с классом 'custom-map' внутри контейнера
    const mapElement = container.querySelector('.custom-map');
    
    if (!mapElement) {
      console.error('Map element not found in container', index);
      return;
    }
    
    // Даём ID если его нет (но не обязательно)
    if (!mapElement.id) {
      mapElement.id = `custom-map-${index}`;
    }
    
    console.log('Creating map for element:', mapElement.id);
    
    new CustomMap(mapElement.id, lat, lng, zoom);
  });
};

class CustomMap {
  constructor(elementId, lat, lng, zoom) {
    this.elementId = elementId;
    this.lat = lat;
    this.lng = lng;
    this.zoom = zoom;
    this.map = null;
    
    this.init();
  }
  
  init() {
    // Проверяем, загружен ли Google Maps
    if (typeof google === 'undefined' || !google.maps) {
      console.error('Google Maps not loaded yet');
      return;
    }
    
    const mapElement = document.getElementById(this.elementId);
    if (!mapElement) {
      console.error('Map element not found:', this.elementId);
      return;
    }
    
    const mapStyles = [
      {
        "elementType": "geometry",
        "stylers": [
          { "color": "#242f3e" },
          { "saturation": -80 },
          { "lightness": 10 }
        ]
      },
      {
        "elementType": "labels.text.fill",
        "stylers": [
          { "color": "#746855" },
          { "saturation": -50 }
        ]
      },
      {
        "elementType": "labels.text.stroke",
        "stylers": [
          { "color": "#242f3e" }
        ]
      },
      {
        "featureType": "administrative.locality",
        "elementType": "labels.text.fill",
        "stylers": [
          { "color": "#d59563" },
          { "saturation": -30 }
        ]
      },
      {
        "featureType": "road",
        "elementType": "geometry",
        "stylers": [
          { "color": "#38414e" },
          { "saturation": -60 }
        ]
      },
      {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [
          { "color": "#212a37" }
        ]
      },
      {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [
          { "color": "#9ca5b3" }
        ]
      },
      {
        "featureType": "water",
        "elementType": "geometry",
        "stylers": [
          { "color": "#17263c" },
          { "saturation": -70 }
        ]
      }
    ];
    
    // Создаём карту
    this.map = new google.maps.Map(mapElement, {
      center: { lat: this.lat, lng: this.lng },
      zoom: this.zoom,
      styles: mapStyles,
      disableDefaultUI: false,
      zoomControl: true,
      mapTypeControl: false,
      streetViewControl: false,
      fullscreenControl: true
    });
    
    // Добавляем наложение цвета
    this.addColorOverlay();
  }
  
  addColorOverlay() {
    const overlay = document.createElement('div');
    overlay.style.position = 'absolute';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.right = '0';
    overlay.style.bottom = '0';
    overlay.style.backgroundColor = '#0f2a1d';
    overlay.style.opacity = '0.21';
    overlay.style.mixBlendMode = 'color';
    overlay.style.pointerEvents = 'none';
    overlay.style.zIndex = '1000';
    
    google.maps.event.addListenerOnce(this.map, 'idle', () => {
      const mapDiv = this.map.getDiv();
      mapDiv.style.position = 'relative';
      mapDiv.appendChild(overlay);
    });
  }
}