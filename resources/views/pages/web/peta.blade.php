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
          <option value="" disabled selected>-- Pilih Lokasi Awal --</option>
          @foreach ($point_start as $point)
            <option value="{{ $point->id }}">{{ $point->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <h2 class="text-success fs-5 fw-semibold mb-2">Pilih Lokasi Wisata</h2>
        <select id="destination" class="form-select mb-3">
          <option value="" disabled selected>-- Pilih Lokasi Wisata --</option>
          @foreach ($point_wisata as $point)
            <option value="{{ $point->id }}">{{ $point->name }}</option>
          @endforeach
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
    const pointStart = @json($point_start);
    const pointWisata = @json($point_wisata);

    const redIcon = L.icon({
      iconUrl: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png',
      iconSize: [32, 32],
      iconAnchor: [16, 32]
    });

    const greenIcon = L.icon({
      iconUrl: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png',
      iconSize: [32, 32],
      iconAnchor: [16, 32]
    });

    const map = L.map('map').setView([3.5952, 98.6722], 12); // Medan

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let startMarkers = [];
    let wisataMarkers = [];
    let routeLine = null;

    function addMarkers() {
      pointStart.forEach(p => {
        const geo = JSON.parse(p.geojson);
        const marker = L.marker([geo.coordinates[1], geo.coordinates[0]], {
            icon: redIcon
          })
          .bindPopup(`<b>${p.name}</b><br>${p.desc}`)
          .addTo(map);
        startMarkers.push({
          id: p.id,
          marker,
          coords: geo.coordinates
        });
      });

      pointWisata.forEach(p => {
        const geo = JSON.parse(p.geojson);
        const marker = L.marker([geo.coordinates[1], geo.coordinates[0]], {
            icon: greenIcon
          })
          .bindPopup(`<b>${p.name}</b><br>${p.category}`)
          .addTo(map);
        wisataMarkers.push({
          id: p.id,
          marker,
          coords: geo.coordinates
        });
      });
    }

    function resetMap() {
      if (routeLine) {
        map.removeLayer(routeLine);
        routeLine = null;
      }
      document.getElementById('routeInfo').classList.add('d-none');
    }

    function findRoute() {
      const startId = document.getElementById('startingPoint').value;
      const destId = document.getElementById('destination').value;

      if (!startId || !destId) {
        alert('Pilih lokasi awal dan tujuan!');
        return;
      }

      const start = startMarkers.find(m => m.id == startId);
      const end = wisataMarkers.find(m => m.id == destId);

      if (!start || !end) {
        alert('Lokasi tidak ditemukan!');
        return;
      }

      const startLatLng = [start.coords[1], start.coords[0]];
      const endLatLng = [end.coords[1], end.coords[0]];

      resetMap();

      // Gambar garis lurus (contoh tanpa routing API)
      routeLine = L.polyline([startLatLng, endLatLng], {
        color: 'blue'
      }).addTo(map);
      map.fitBounds(routeLine.getBounds());

      // Tampilkan info rute dasar
      const distance = map.distance(startLatLng, endLatLng) / 1000; // km
      document.getElementById('routeDistance').innerText = `Jarak: ${distance.toFixed(2)} km`;
      document.getElementById('routeDuration').innerText =
        `Perkiraan Waktu: ${(distance / 30 * 60).toFixed(0)} menit`; // asumsikan 30km/h
      document.getElementById('routeInfo').classList.remove('d-none');
    }

    document.getElementById('findRoute').addEventListener('click', findRoute);
    document.getElementById('resetMap').addEventListener('click', resetMap);

    addMarkers();
  </script>
@endpush
