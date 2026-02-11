@push('styles')
    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .marker-cluster-small {
            background-color: rgba(181, 226, 140, 0.6);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            let mapInstance = null;
            let markersLayer = null;

            const initMap = () => {
                const mapElement = document.getElementById('map');
                if (!mapElement || mapInstance) return;

                // Pusat Kota Mataram
                mapInstance = L.map('map').setView([-8.5826, 116.1051], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
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
                        // Custom red icon for violations
                        const redIcon = L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });

                        L.marker([loc.lat, loc.lng], { icon: redIcon })
                            .addTo(markersLayer)
                            .bindPopup(
                                `<div class="p-2">
                                    <h6 class="fw-bold text-danger mb-2">${loc.no_pelanggaran}</h6>
                                    <p class="mb-1"><strong>Alamat:</strong> ${loc.alamat}</p>
                                    <p class="mb-1"><strong>Lokasi:</strong> Kel. ${loc.kelurahan}, Kec. ${loc.kecamatan}</p>
                                    <p class="mb-1"><strong>Tindak Lanjut:</strong> ${loc.tindak_lanjut}</p>
                                    <p class="mb-0"><strong>Status:</strong> <span class="badge bg-warning text-dark">${loc.info}</span></p>
                                </div>`
                            );
                    }
                });

                // Auto zoom logic
                const group = new L.featureGroup(markersLayer.getLayers());
                if (markersLayer.getLayers().length > 0) {
                    mapInstance.fitBounds(group.getBounds().pad(0.2));
                    if (markersLayer.getLayers().length === 1) {
                        mapInstance.setZoom(16);
                    }
                }
            };

            initMap();

            Livewire.on('refresh-map', () => {
                const updatedLocations = @this.locations;
                addMarkers(updatedLocations);
            });
        });
    </script>
@endpush

<div>
    <section class="bg-danger text-white py-5" style="margin-top: 70px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Peta Sebaran Pelanggaran</h1>
                    <p class="lead">Peta Indikasi Pelanggaran Tata Ruang Kota Mataram</p>
                </div>
            </div>
        </div>
    </section>

    <section id="peta-pelanggaran" class="bg-light"
        style="padding-top: 2rem !important; padding-bottom: 2rem !important;">
        <div wire:ignore class="container">
            <!-- Filter Section -->
            <div class="row justify-content-center mb-4 g-3">
                <div class="col-md-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-geo-alt text-danger"></i></span>
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

                <div class="col-md-2">
                    <button class="btn btn-danger w-100 shadow-sm" wire:click="filterMap">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                </div>
            </div>

            <div class="row g-2">
                <div id="map" class="col-12" style="border: 2px solid #dc3545;"></div>
            </div>
        </div>
    </section>
</div>
