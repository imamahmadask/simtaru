<div>
    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #map {
            height: 550px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener('livewire:initialized', () => {
            let mapInstance = null;
            let markersLayer = null;

            const initMap = () => {
                const mapElement = document.getElementById('map');
                if (!mapElement || mapInstance) return;

                // Pusat Kota Mataram sebagai default
                mapInstance = L.map('map').setView([-8.5826, 116.1051], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(mapInstance);

                markersLayer = L.layerGroup().addTo(mapInstance);
                addMarkers(@js($locations));
            };

            const addMarkers = (locations) => {
                if (!markersLayer || !locations) return;

                markersLayer.clearLayers();

                if (locations.length === 0) return;

                locations.forEach(loc => {
                    if (loc.lat && loc.lng) {
                        L.marker([loc.lat, loc.lng])
                            .addTo(markersLayer)
                            .bindPopup(
                                `<b>${loc.name}</b><br>${loc.info}<br>${loc.alamat}<br>${loc.kelurahan}<br>${loc.kecamatan}`
                            );
                    }
                });

                // LOGIKA ZOOM OTOMATIS
                const group = new L.featureGroup(markersLayer.getLayers());
                if (markersLayer.getLayers().length > 0) {
                    // fitBounds akan menyesuaikan layar agar semua marker terlihat
                    mapInstance.fitBounds(group.getBounds().pad(0.2));

                    // Jika hanya ada 1 marker, set zoom level secara manual agar tidak terlalu dekat
                    if (markersLayer.getLayers().length === 1) {
                        mapInstance.setZoom(16);
                    }
                }
            };

            // Inisialisasi awal
            initMap();

            // Listen event dari Livewire
            Livewire.on('refresh-map', () => {
                // Ambil data terbaru langsung dari properti Livewire
                const updatedLocations = @this.locations;
                addMarkers(updatedLocations);
            });
        });
    </script>

    <div wire:ignore class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-4 fw-bold text-dark mb-4">Peta Digital Interaktif</h2>
                <p class="lead text-muted">
                    Peta Informasi Perizinan Pemanfaatan Ruang Kota Mataram
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
