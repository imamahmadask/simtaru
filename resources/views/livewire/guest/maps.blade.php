<div>
    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #map {
            height: 550px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let mapInstance = null;
            let markersLayer = null;

            const initMap = () => {
                const mapElement = document.getElementById('map');
                if (!mapElement || mapInstance) return;

                // Inisialisasi peta
                mapInstance = L.map('map').setView([-8.58261111508778, 116.10517768762094], 5);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(mapInstance);

                markersLayer = L.layerGroup().addTo(mapInstance);
                addMarkers(); // Tambah marker awal
            };

            const addMarkers = () => {
                if (!markersLayer) return;
                markersLayer.clearLayers(); // Hapus marker lama

                const locations = @js($locations); // Data dari Livewire

                locations.forEach(loc => {
                    L.marker([loc.lat, loc.lng])
                        .addTo(markersLayer)
                        .bindPopup(`<b>${loc.name}</b><br>${loc.info}<br>${loc.alamat}<br>${loc.kelurahan}<br>${loc.kecamatan}`);
                });

                // Opsional: Zoom ke semua marker
                if (locations.length > 0) {
                    const group = new L.featureGroup(markersLayer.getLayers());
                    mapInstance.fitBounds(group.getBounds().pad(0.5));
                }
            };

            // Hook Livewire untuk update setelah render ulang
            Livewire.hook('morph.updated', ({ el, component }) => {
                if (el.id === 'map' || component.id === @js($this->getId())) {
                    addMarkers(); // Update marker saja, tanpa rebuild peta
                }
            });

            // Inisialisasi awal
            initMap();

            // Listen to Livewire event for map refresh
            Livewire.on('refresh-map', () => {
                // Re-fetch locations from the updated component
                const updatedLocations = @this.locations;                
                
                if (!markersLayer) return;
                markersLayer.clearLayers(); // Clear old markers
                
                updatedLocations.forEach(loc => {
                    L.marker([loc.lat, loc.lng])
                        .addTo(markersLayer)
                        .bindPopup(`<b>${loc.name}</b><br>${loc.info}<br>${loc.alamat}<br>${loc.kelurahan}<br>${loc.kecamatan}`);
                });
                
                // Zoom to fit all markers
                if (updatedLocations.length > 0) {
                    const group = new L.featureGroup(markersLayer.getLayers());
                    mapInstance.fitBounds(group.getBounds().pad(0.5));
                }
            });
        });
    </script>

    <div wire:ignore class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-4 fw-bold text-dark mb-4">Peta Digital</h2>
                <p class="lead text-muted">
                    Visualisasi interaktif Rencana Tata Ruang Wilayah Kota Mataram
                </p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row justify-content-center mb-4 g-3">
            <div class="col-md-4">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0"><i
                            class="bi bi-geo-alt text-primary"></i></span>
                    <select wire:model="kecamatan" class="form-select border-start-0" aria-label="Filter Kecamatan">
                        <option value="" selected>Semua Kecamatan</option>
                        <option value="Ampenan">Ampenan</option>
                        <option value="Cakranegara">Cakranegara</option>
                        <option value="Mataram">Mataram</option>
                        <option value="Sandubaya">Sandubaya</option>
                        <option value="Sekarbela">Sekarbela</option>
                        <option value="Selaparang">Selaparang</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-layers text-primary"></i></span>
                    <select class="form-select border-start-0" aria-label="Filter Pemanfaatan Ruang">
                        <option selected>Semua Pemanfaatan Ruang</option>
                        <option value="Rumah Tinggal">Rumah Tinggal</option>
                        <option value="Perumahan">Perumahan</option>
                        <option value="Perdagangan">Perdagangan</option>
                        <option value="Perkantoran">Perkantoran</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100 shadow-sm" wire:click="filterMap">
                    <i class="bi bi-filter me-2"></i>Filter
                </button>
            </div>
        </div>

        <div class="row g-2">
            <div id="map" class="col-12"></div>
        </div>
    </div>
</div>