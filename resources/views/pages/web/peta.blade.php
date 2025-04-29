@extends('layouts.web.app')

@push('styles')
  <style>
    #map {
      height: 100vh;
    }

    .map-container {
      height: 90vh;
      position: relative;
      flex: 1;
      overflow: hidden;
    }

    .legend {
      background-color: white;
      border-radius: 5px;
      box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
      position: absolute;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
    }

    .legend-color {
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: inline-block;
      margin-right: 8px;
    }

    .legend-line {
      width: 16px;
      height: 4px;
      display: inline-block;
      margin-right: 8px;
      vertical-align: middle;
    }
  </style>
@endpush

@section('content')
  <div class="container-fluid d-flex flex-column flex-md-row mt-5 mb-5">
    <!-- Sidebar -->
    <div class="bg-light p-4 overflow-auto mt-4" style="max-width: 350px;">
      <h1 class="text-success fs-4 fw-bold mb-4">Peta Wisata Kota Medan</h1>

      <div class="mb-4">
        <h2 class="text-success fs-5 fw-semibold mb-2">Pilih Lokasi Awal</h2>
        <select id="startingPoint" class="form-select mb-3">
          <option value="">-- Pilih Lokasi Awal --</option>
          <option value="pinang_baris">Terminal Pinang Baris</option>
          <option value="amplas">Terminal Amplas</option>
          <option value="pusat_kota">Pusat Kota Medan</option>
        </select>
      </div>

      <div class="mb-4">
        <h2 class="text-success fs-5 fw-semibold mb-2">Pilih Lokasi Wisata</h2>
        <select id="destination" class="form-select mb-3">
          <option value="">-- Pilih Lokasi Wisata --</option>
          <option value="lapangan_merdeka">Lapangan Merdeka</option>
          <option value="park_zoo">Medan Park Zoo</option>
          <option value="kebun_binatang">Kebun Binatang Medan</option>
          <option value="tjong_afie">Tjong A Fie Mansion</option>
        </select>
      </div>

      <button id="findRoute" class="btn btn-success w-100 mb-2">Cari Rute</button>
      <button id="resetMap" class="btn btn-danger w-100 mb-3">Reset Peta</button>

      <div id="loading" class="text-center text-success my-3 d-none">
        <div class="spinner-border spinner-border-sm me-2" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        Mencari rute optimal...
      </div>

      <div id="routeInfo" class="alert alert-success mb-3 d-none">
        <h5 class="alert-heading fs-6 fw-bold">Informasi Rute</h5>
        <div id="routeDistance"></div>
        <div id="routeDuration"></div>
      </div>

      <div id="infoPanel" class="card">
        <div class="card-body">
          <h5 class="card-title text-success fw-bold fs-6">Informasi Wisata</h5>
          <p class="card-text small">
            Klik pada lokasi wisata di peta untuk melihat informasi atau pilih lokasi dari menu dropdown.
          </p>
        </div>
      </div>
    </div>

    <!-- Map Container -->
    <div class="map-container w-100 mt-4">
      <div id="map"></div>
      <div class="legend card p-2">
        <h3 class="card-title fs-6 fw-semibold mb-2">Legenda</h3>
        <div class="mb-1">
          <div class="legend-color bg-danger"></div>
          <span class="small">Lokasi Awal</span>
        </div>
        <div class="mb-1">
          <div class="legend-color bg-success"></div>
          <span class="small">Lokasi Wisata</span>
        </div>
        <div>
          <div class="legend-line bg-primary"></div>
          <span class="small">Rute Perjalanan</span>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    const map = L.map('map').setView([3.5952, 98.6722], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const locations = {
      pinang_baris: {
        name: "Terminal Pinang Baris",
        latlng: [3.6128, 98.6480],
        type: "start",
        description: "Terminal bus di bagian barat kota Medan."
      },
      amplas: {
        name: "Terminal Amplas",
        latlng: [3.5601, 98.7040],
        type: "start",
        description: "Terminal bus utama di Medan bagian selatan."
      },
      pusat_kota: {
        name: "Pusat Kota Medan",
        latlng: [3.5952, 98.6722],
        type: "start",
        description: "Pusat kota Medan dengan berbagai aktivitas komersial."
      },
      lapangan_merdeka: {
        name: "Lapangan Merdeka",
        latlng: [3.5889, 98.6748],
        type: "destination",
        description: "Lapangan publik yang luas di pusat kota."
      },
      park_zoo: {
        name: "Medan Park Zoo",
        latlng: [3.5698, 98.6475],
        type: "destination",
        description: "Taman rekreasi dan kebun binatang."
      },
      kebun_binatang: {
        name: "Kebun Binatang Medan",
        latlng: [3.5798, 98.6558],
        type: "destination",
        description: "Kebun binatang dengan koleksi satwa."
      },
      tjong_afie: {
        name: "Tjong A Fie Mansion",
        latlng: [3.5856, 98.6789],
        type: "destination",
        description: "Bangunan bersejarah di Medan."
      }
    };

    let startMarker = null;
    let destinationMarker = null;
    let routeControl = null;
    const allDestinationMarkers = {};

    function showAllDestinations() {
      for (const key in allDestinationMarkers) {
        if (allDestinationMarkers[key]) {
          map.removeLayer(allDestinationMarkers[key]);
        }
      }

      for (const key in locations) {
        const location = locations[key];
        if (location.type === "destination") {
          const marker = L.marker(location.latlng, {
            icon: L.divIcon({
              className: 'custom-div-icon',
              html: `<div style="background-color: #198754; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>`,
              iconSize: [16, 16],
              iconAnchor: [8, 8]
            }),
            title: location.name
          }).addTo(map);

          marker.bindPopup(`<strong>${location.name}</strong><br><small>${location.description}</small>`);
          marker.on('click', function() {
            updateInfoPanel(location);
          });

          allDestinationMarkers[key] = marker;
        }
      }
    }

    function updateInfoPanel(location) {
      document.getElementById('infoPanel').innerHTML = `
        <div class="card-body">
          <h5 class="card-title text-success fw-bold fs-6">${location.name}</h5>
          <p class="card-text small">${location.description}</p>
        </div>
      `;
    }

    function displayRoute() {
      const startId = document.getElementById('startingPoint').value;
      const destId = document.getElementById('destination').value;

      if (!startId || !destId) {
        showToast("Harap pilih lokasi awal dan tujuan wisata!");
        return;
      }

      document.getElementById('loading').classList.remove('d-none');
      resetMap(false);

      const startLocation = locations[startId];
      const destLocation = locations[destId];

      startMarker = L.marker(startLocation.latlng, {
        icon: L.divIcon({
          html: `<div style="background-color: #dc3545; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>`,
          iconSize: [16, 16],
          iconAnchor: [8, 8]
        })
      }).addTo(map).bindPopup(`<strong>${startLocation.name}</strong><br><small>${startLocation.description}</small>`);

      destinationMarker = L.marker(destLocation.latlng, {
        icon: L.divIcon({
          html: `<div style="background-color: #198754; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white;"></div>`,
          iconSize: [16, 16],
          iconAnchor: [8, 8]
        })
      }).addTo(map).bindPopup(`<strong>${destLocation.name}</strong><br><small>${destLocation.description}</small>`);

      if (routeControl) {
        map.removeControl(routeControl);
      }

      routeControl = L.Routing.control({
        waypoints: [
          L.latLng(startLocation.latlng[0], startLocation.latlng[1]),
          L.latLng(destLocation.latlng[0], destLocation.latlng[1])
        ],
        lineOptions: {
          styles: [{
            color: '#0d6efd',
            opacity: 0.7,
            weight: 5
          }]
        },
        routeWhileDragging: false,
        addWaypoints: false,
        draggableWaypoints: false,
        fitSelectedRoutes: true,
        showAlternatives: false,
        createMarker: function() {
          return null;
        }
      }).addTo(map);

      routeControl.on('routesfound', function(e) {
        const summary = e.routes[0].summary;
        document.getElementById('routeDistance').textContent =
          `Jarak: ${(summary.totalDistance / 1000).toFixed(1)} km`;
        document.getElementById('routeDuration').textContent =
          `Waktu tempuh: ${Math.round(summary.totalTime / 60)} menit`;
        document.getElementById('routeInfo').classList.remove('d-none');
        document.getElementById('loading').classList.add('d-none');
      });

      updateInfoPanel(destLocation);
    }

    function resetMap(resetDropdown = true) {
      if (startMarker) {
        map.removeLayer(startMarker);
        startMarker = null;
      }
      if (destinationMarker) {
        map.removeLayer(destinationMarker);
        destinationMarker = null;
      }
      if (routeControl) {
        map.removeControl(routeControl);
        routeControl = null;
      }
      if (resetDropdown) {
        document.getElementById('startingPoint').value = "";
        document.getElementById('destination').value = "";
        document.getElementById('routeInfo').classList.add('d-none');
      }
      showAllDestinations();
    }

    function showToast(message) {
      let toastContainer = document.getElementById('toast-container');
      if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(toastContainer);
      }

      const toast = document.createElement('div');
      toast.className = 'toast align-items-center text-bg-danger border-0 show mb-2';
      toast.setAttribute('role', 'alert');
      toast.innerHTML = `
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
      `;

      toastContainer.appendChild(toast);
      setTimeout(() => toast.remove(), 3000);
    }

    document.getElementById('findRoute').addEventListener('click', displayRoute);
    document.getElementById('resetMap').addEventListener('click', () => resetMap(true));

    showAllDestinations();
  </script>
@endpush
