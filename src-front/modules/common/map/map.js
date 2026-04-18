const initMap = function initMap() {
  if (window.homeMap) {
    return;
  }
  if (typeof google === 'undefined' || !google.maps) {
    return;
  }

  const mapElement = document.getElementById('map');

  if (!mapElement) {
    return;
  }

  const map = new google.maps.Map(mapElement, {
    center: { lat: 43.6532, lng: -79.3832 },
    zoom: 12,
    mapId: '598d7637de918571ede17e8f'
  });

  window.homeMap = map;
};

window.initMap = initMap;

if (typeof google !== 'undefined' && google.maps) {
  window.initMap();
}
