@extends('layouts.web.app')

@push('styles')
  {{-- Virtual Select --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/virtual-select-plugin@1.0.46/dist/virtual-select.min.css"
    integrity="sha256-2J2LphAasJ6yO+ZAylnzWM2N1xHblyZeVK9j0EoJpOQ=" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/virtual-select-plugin@1.0.46/dist/virtual-select.min.js"
    integrity="sha256-vvp5tsZt6dxBdWuGfMnKqHOplFUmacnAc3qtNAZ1HkM=" crossorigin="anonymous"></script>

  <style>
    #map {
      height: 90vh;
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
      z-index: 500;
      padding: 10px;
    }

    /* Map Controls */
    .map-control {
      background: white;
      border-radius: 6px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      padding: 8px;
      z-index: 400;
    }

    .layer-control {
      position: absolute;
      bottom: 20px;
      left: 20px;
      font-size: 14px;
    }

    .fullscreen-control {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      padding: 8px 10px;
      background: white;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
    }

    .fullscreen-control:hover {
      background-color: #f8f9fa;
      transform: scale(1.05);
    }

    .fullscreen-control i {
      font-size: 20px;
      color: #198754;
    }

    /* Fullscreen mode */
    .map-fullscreen {
      position: fixed !important;
      top: 3rem !important;
      left: 0 !important;
      width: 90vw !important;
      height: 90vh !important;
      z-index: 9999 !important;
      margin: 0 !important;
      padding: 0 !important;
      border-radius: 0 !important;
      max-width: none !important;
    }

    .map-fullscreen #map {
      height: 100vh !important;
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

    /* Modern Sidebar Styles */
    .sidebar {
      max-width: 380px;
      width: 100%;
      height: 90vh;
      overflow-y: auto;
      scrollbar-width: thin;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
    }

    .sidebar::-webkit-scrollbar {
      width: 6px;
    }

    .sidebar::-webkit-scrollbar-thumb {
      background-color: #198754;
      border-radius: 10px;
    }

    /* Button Navigation Styling */
    .nav-buttons {
      margin-bottom: 20px;
    }

    .nav-btn {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 12px 8px;
      border-radius: 10px;
      background-color: #f8f9fa;
      border: none;
      color: #6c757d;
      transition: all 0.3s ease;
    }

    .nav-btn i {
      font-size: 20px;
      margin-bottom: 5px;
    }

    .nav-btn span {
      font-size: 12px;
      font-weight: 600;
    }

    .nav-btn:hover {
      background-color: #e9ecef;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: #198754;
    }

    .nav-btn.active {
      background-color: #198754;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(25, 135, 84, 0.25);
    }

    /* Content Sections */
    .content-section {
      display: none;
      margin-bottom: 20px;
      animation: fadeIn 0.5s ease;
    }

    .content-section.active {
      display: block;
    }

    .section-header {
      padding: 0 0 12px 0;
      margin-bottom: 15px;
      border-bottom: 2px solid #e9ecef;
    }

    .section-content {
      background-color: #f8f9fa;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* Badge Styling */
    .filter-badge {
      font-size: 11px;
      padding: 6px 12px;
      margin: 3px;
      cursor: pointer;
      border-radius: 20px;
      border: 1px solid #dee2e6;
      background-color: white;
      transition: all 0.25s;
      display: inline-block;
    }

    .filter-badge:hover {
      border-color: #198754;
      transform: translateY(-2px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .filter-badge.active {
      background-color: #198754;
      color: white;
      border-color: #198754;
      box-shadow: 0 2px 5px rgba(25, 135, 84, 0.3);
    }

    /* Action Buttons */
    .btn-action {
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: all 0.3s;
    }

    .btn-action:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Search Input Styling */
    .input-group-text {
      border-radius: 8px 0 0 8px;
    }

    #districtSearch {
      border-radius: 0 8px 8px 0;
      transition: all 0.3s ease;
    }

    #districtSearch:focus {
      box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
      border-color: #198754;
    }

    /* Route Info Styling */
    #routeInfo {
      border-radius: 10px;
      border-left: 4px solid #198754;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    /* Tourist Info Panel */
    #infoPanel {
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      border: none;
      transition: all 0.3s ease;
    }

    #infoPanel .card-header {
      border-bottom: 2px solid #e9ecef;
    }

    /* Animation */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
@endpush

@section('content')
  <div class="container-fluid d-flex flex-column flex-md-row mt-5 mb-5">
    <!-- Modern Sidebar -->
    <!-- Modern Sidebar with Button Navigation -->
    <div class="bg-white p-4 sidebar me-md-3 mt-4">
      <div class="d-flex align-items-center mb-4">
        <i class="bi bi-map-fill text-success fs-4 me-2"></i>
        <h1 class="text-success fs-4 fw-bold m-0">Peta Wisata Kota Medan</h1>
      </div>

      <!-- Main Navigation Buttons -->
      <div class="nav-buttons mb-4">
        <div class="d-flex gap-2 justify-content-between">
          <button class="btn nav-btn active" data-target="route-section">
            <i class="bi bi-signpost-split"></i>
            <span>Rute</span>
          </button>
          <button class="btn nav-btn" data-target="category-section">
            <i class="bi bi-tags"></i>
            <span>Kategori</span>
          </button>
          <button class="btn nav-btn" data-target="district-section">
            <i class="bi bi-geo-alt"></i>
            <span>Kecamatan</span>
          </button>
        </div>
      </div>

      <!-- Content Sections -->
      <div class="content-sections">
        <!-- Route Planning Section -->
        <div id="route-section" class="content-section active">
          <div class="section-header d-flex align-items-center">
            <h2 class="fs-5 fw-semibold m-0">Perencanaan Rute</h2>
          </div>

          <div class="section-content rounded-3">
            <div class="mb-3">
              <label for="startingPoint" class="form-label small fw-semibold text-secondary">Lokasi Awal</label>
              <div id="start-select" placeholder="-- Pilih Lokasi Awal --"></div>
            </div>

            <div class="mb-3">
              <label for="destination" class="form-label small fw-semibold text-secondary">Lokasi Wisata</label>
              <div id="wisata-select" placeholder="-- Pilih Lokasi Wisata --"></div>
            </div>

            <div class="d-grid gap-2">
              <button id="findRoute" class="btn btn-success btn-sm btn-action">
                <i class="bi bi-search me-1"></i> Cari Rute
              </button>
              <button id="resetMap" class="btn btn-outline-danger btn-sm btn-action">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Peta
              </button>
            </div>
          </div>
        </div>

        <!-- Category Filter Section -->
        <div id="category-section" class="content-section">
          <div class="section-header d-flex align-items-center mb-3">
            <h2 class="fs-5 fw-semibold m-0">Filter Kategori</h2>
          </div>

          <div class="section-content p-3 rounded-3">
            <div class="d-flex flex-wrap" id="categoryFilters">
              <span class="filter-badge active" data-category="all">Semua</span>
              @foreach ($point_wisata->unique('category') as $wisata)
                @if ($wisata->category)
                  <span class="filter-badge"
                    data-category="wisata-{{ $wisata->category }}">{{ ucfirst($wisata->category) }}</span>
                @endif
              @endforeach
            </div>
          </div>
        </div>

        <!-- District Filter Section -->
        <div id="district-section" class="content-section">
          <div class="section-header d-flex align-items-center mb-3">
            <h2 class="fs-5 fw-semibold m-0">Filter Kecamatan</h2>
          </div>

          <div class="section-content p-3 rounded-3">
            <div class="mb-3">
              <div class="input-group input-group-sm">
                <span class="input-group-text bg-white border-end-0">
                  <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control form-control-sm border-start-0" id="districtSearch"
                  placeholder="Cari kecamatan...">
              </div>
            </div>
            <div class="d-flex flex-wrap mt-2" id="districtFilters">
              <span class="filter-badge active" data-district="all">Semua</span>
              <span class="filter-badge" data-district="medan-kota">Medan Kota</span>
              <span class="filter-badge" data-district="medan-petisah">Medan Petisah</span>
              <span class="filter-badge" data-district="medan-barat">Medan Barat</span>
              <span class="filter-badge" data-district="medan-timur">Medan Timur</span>
              <span class="filter-badge" data-district="medan-maimun">Medan Maimun</span>
              <span class="filter-badge" data-district="medan-polonia">Medan Polonia</span>
              <span class="filter-badge" data-district="medan-baru">Medan Baru</span>
              <span class="filter-badge" data-district="medan-tuntungan">Medan Tuntungan</span>
              <span class="filter-badge" data-district="medan-selayang">Medan Selayang</span>
              <span class="filter-badge" data-district="medan-johor">Medan Johor</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Loading and Route Info -->
      <div id="loading" class="text-center text-success my-3 d-none">
        <div class="spinner-border spinner-border-sm me-2" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <span class="small">Mencari rute optimal...</span>
      </div>

      <div id="routeInfo" class="alert alert-success mb-3 d-none">
        <div class="d-flex align-items-center mb-2">
          <i class="bi bi-info-circle-fill me-2"></i>
          <h5 class="alert-heading fs-6 fw-bold m-0">Informasi Rute</h5>
        </div>
        <hr class="my-2">
        <div id="routeDistance" class="small"></div>
        <div id="routeDuration" class="small"></div>
      </div>

      <!-- Tourist Info Panel -->
      <div id="infoPanel" class="card filter-card">
        <div class="card-header d-flex align-items-center py-2 px-3 bg-light">
          <i class="bi bi-info-circle me-2 text-success"></i>
          <h5 class="card-title text-success fw-bold fs-6 m-0">Informasi Wisata</h5>
        </div>
        <div class="card-body p-3">
          <div id="touristInfo">
            <p class="card-text small mb-0">
              Klik pada lokasi wisata di peta untuk melihat informasi atau pilih lokasi dari menu dropdown.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Map Container -->
    <div class="map-container w-100 mt-4"
      style="border-radius: 12px; overflow: hidden; box-shadow: 0 0 15px rgba(0,0,0,0.1);">
      <div id="map"></div>

      <!-- Fullscreen control -->
      <div class="fullscreen-control" id="fullscreenControl" title="Tampilan Layar Penuh">
        <i class="bi bi-arrows-fullscreen"></i>
      </div>

      <!-- Layer control -->
      <div class="layer-control map-control">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h6 class="m-0 fw-semibold fs-6">Layer Peta</h6>
        </div>
        <hr class="my-2">
        <div class="layer-options">
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="mapLayerRadio" id="layerOSM" checked>
            <label class="form-check-label small" for="layerOSM">
              OpenStreetMap
            </label>
          </div>
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="mapLayerRadio" id="layerSatellite">
            <label class="form-check-label small" for="layerSatellite">
              Satellite
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="layerDistrict">
            <label class="form-check-label small" for="layerDistrict">
              Batas Kecamatan
            </label>
          </div>
        </div>
      </div>

      <!-- Legend -->
      <div class="legend card">
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
  <!-- Bootstrap Icons CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <script>
    document.addEventListener('DOMContentLoaded', function() {

      const script = document.createElement('script');
      script.src = 'https://cdn.jsdelivr.net/npm/leaflet-geometryutil@0.10.0/src/leaflet.geometryutil.min.js';
      script.onload = function() {
        initMap();
      };
      document.head.appendChild(script);

      const navButtons = document.querySelectorAll('.nav-btn');
      const contentSections = document.querySelectorAll('.content-section');

      navButtons.forEach(button => {
        button.addEventListener('click', function() {
          navButtons.forEach(btn => btn.classList.remove('active'));

          this.classList.add('active');

          contentSections.forEach(section => section.classList.remove('active'));

          const targetSection = document.getElementById(this.dataset.target);
          targetSection.classList.add('active');
        });
      });


    });

    function initMap() {
      const pointStart = @json($point_start);
      // console.log(pointStart)
      const pointWisata = @json($point_wisata);
      // console.log(pointWisata)
      const kecamatan = @json($kecamatan);

      // Default tourist info
      const defaultTouristInfo = document.getElementById('touristInfo').innerHTML;

      const startEl = document.querySelector('#start-select');
      const wisataEl = document.querySelector('#wisata-select');

      VirtualSelect.init({
        ele: startEl,
        multiple: false,
        options: pointStart.map(point => ({
          label: point.name,
          value: point.id
        })),
        search: true,
      });

      VirtualSelect.init({
        ele: wisataEl,
        multiple: false,
        options: pointWisata.map(point => ({
          label: point.name,
          value: point.id
        })),
        search: true,
      });

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

      const map = L.map('map').setView([3.5952, 98.6722], 12);

      const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
      }).addTo(map);

      const satelliteLayer = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
          attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
        });

      document.getElementById('layerOSM').addEventListener('change', function() {
        if (this.checked) {
          map.removeLayer(satelliteLayer);
          map.addLayer(osmLayer);
        }
      });

      document.getElementById('layerSatellite').addEventListener('change', function() {
        if (this.checked) {
          map.removeLayer(osmLayer);
          map.addLayer(satelliteLayer);
        }
      });

      document.getElementById('layerDistrict').addEventListener('change', function() {
        if (this.checked && kecamatanLayer) {
          kecamatanLayer.addTo(map);
        } else if (kecamatanLayer) {
          map.removeLayer(kecamatanLayer);
        }
      });

      let allMarkers = [];
      let selectedStartMarker = null;
      let selectedWisataMarker = null;
      let selectedStartCoords = null;
      let selectedWisataCoords = null;

      function clearAllMarkers() {
        allMarkers.forEach(m => map.removeLayer(m));
        allMarkers = [];

        if (selectedStartMarker) map.removeLayer(selectedStartMarker);
        if (selectedWisataMarker) map.removeLayer(selectedWisataMarker);
        selectedStartMarker = null;
        selectedWisataMarker = null;
      }

      function showAllMarkers() {
        clearAllMarkers();

        pointStart.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const marker = L.marker([coords[1], coords[0]], {
              icon: redIcon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.desc}`)
            .addTo(map);

          allMarkers.push(marker);
          document.getElementById('touristInfo').innerHTML = defaultTouristInfo;
          startEl.reset();
          wisataEl.reset();

        });

        pointWisata.forEach(point => {
          const geo = JSON.parse(point.geojson);
          const coords = geo.coordinates;

          const marker = L.marker([coords[1], coords[0]], {
              icon: greenIcon
            })
            .bindPopup(`<b>${point.name}</b><br>${point.desc}`)
            .addTo(map);

          allMarkers.push(marker);
        });

        map.setView([3.5952, 98.6722], 12); // view awal
      }

      function clearAllMarkers() {
        allMarkers.forEach(m => map.removeLayer(m));
        allMarkers = [];

        if (selectedStartMarker) map.removeLayer(selectedStartMarker);
        if (selectedWisataMarker) map.removeLayer(selectedWisataMarker);
        selectedStartMarker = null;
        selectedWisataMarker = null;
      }

      function showSelectedRoute() {
        clearAllMarkers();

        const startId = startEl.virtualSelect.getValue();
        const wisataId = wisataEl.virtualSelect.getValue();

        const start = pointStart.find(p => p.id == startId);
        const wisata = pointWisata.find(p => p.id == wisataId);

        if (!start || !wisata) {
          alert("Silakan pilih titik awal dan lokasi wisata.");
          return;
        }

        const startCoords = JSON.parse(start.geojson).coordinates;
        const wisataCoords = JSON.parse(wisata.geojson).coordinates;

        selectedStartCoords = [startCoords[1], startCoords[0]];
        selectedWisataCoords = [wisataCoords[1], wisataCoords[0]];

        selectedStartMarker = L.marker(selectedStartCoords, {
            icon: redIcon
          })
          .bindPopup(`<b>${start.name}</b><br>${start.desc}`)
          .addTo(map);

        selectedWisataMarker = L.marker(selectedWisataCoords, {
            icon: greenIcon
          })
          .bindPopup(`<b>${wisata.name}</b><br>${wisata.desc}`)
          .addTo(map);

        const bounds = L.latLngBounds([selectedStartCoords, selectedWisataCoords]);
        map.fitBounds(bounds, {
          padding: [70, 70]
        });

        document.getElementById('touristInfo').innerHTML = `
          <h6 class="fw-bold mb-1 text-success">${wisata.name}</h6>
          <p class="mb-0 small">${wisata.desc}</p>
        `;
      }

      document.getElementById('findRoute').addEventListener('click', showSelectedRoute);
      document.getElementById('resetMap').addEventListener('click', showAllMarkers);

      showAllMarkers();

      // Fullscreen toggle
      let isFullscreen = false;
      const mapContainer = document.querySelector('.map-container');
      const fullscreenControl = document.getElementById('fullscreenControl');

      fullscreenControl.addEventListener('click', function() {
        if (!isFullscreen) {
          // Enter fullscreen
          mapContainer.style.position = 'fixed';
          mapContainer.style.top = '3rem';
          mapContainer.style.left = '0';
          mapContainer.style.height = '90vh';
          mapContainer.style.zIndex = '9999';
          mapContainer.style.borderRadius = '0';
          fullscreenControl.querySelector('i').classList.remove('bi-arrows-fullscreen');
          fullscreenControl.querySelector('i').classList.add('bi-fullscreen-exit');
          document.body.style.overflow = 'hidden';
          isFullscreen = true;
        } else {
          // Exit fullscreen
          mapContainer.style.position = 'relative';
          mapContainer.style.top = 'auto';
          mapContainer.style.left = 'auto';
          mapContainer.style.width = '100%';
          mapContainer.style.height = '90vh';
          mapContainer.style.zIndex = '1';
          mapContainer.style.borderRadius = '12px';
          fullscreenControl.querySelector('i').classList.remove('bi-fullscreen-exit');
          fullscreenControl.querySelector('i').classList.add('bi-arrows-fullscreen');
          document.body.style.overflow = 'auto';
          isFullscreen = false;
        }

        // Trigger resize event to update map
        setTimeout(() => {
          window.dispatchEvent(new Event('resize'));
          map.invalidateSize();
        }, 100);
      });
    }
  </script>
@endpush
