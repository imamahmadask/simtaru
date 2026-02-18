@push('styles')
    <!-- Leaflet CDN -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
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
                        // Custom blue icon for assessments
                        const blueIcon = L.icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });

                        L.marker([loc.lat, loc.lng], { icon: blueIcon })
                            .addTo(markersLayer)
                            .bindPopup(
                                `<div class="p-1" style="min-width: 250px;">
                                    <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">${loc.nomor_dokumen || 'Tanpa No Dokumen'}</h6>
                                    <table class="table table-sm table-borderless mb-0" style="font-size: 0.85rem;">
                                        <tr>
                                            <td class="ps-0" style="width: 120px;"><strong>Tanggal Penilaian</strong></td>
                                            <td class="pe-0">: ${loc.tanggal_penilaian}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0"><strong>Jenis Penilaian</strong></td>
                                            <td class="pe-0">: ${loc.jenis_penilaian}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0"><strong>Nama Usaha</strong></td>
                                            <td class="pe-0">: ${loc.nama_usaha}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0"><strong>Alamat Lokasi Usaha</strong></td>
                                            <td class="pe-0">: ${loc.alamat || '-'}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0"><strong>Jenis Kegiatan Usaha</strong></td>
                                            <td class="pe-0">: ${loc.jenis_kegiatan_usaha}</td>
                                        </tr>
                                        <tr>
                                            <td class="ps-0"><strong>Analisa Penilaian</strong></td>
                                            <td class="pe-0">: <span class="badge ${loc.analisa_penilaian === 'Sesuai Seluruhnya' ? 'bg-success' : 'bg-warning'}">${loc.analisa_penilaian}</span></td>
                                        </tr>
                                    </table>
                                </div>`
                            );
                    }
                });

                if (markersLayer.getLayers().length > 0) {
                    const group = new L.featureGroup(markersLayer.getLayers());
                    mapInstance.fitBounds(group.getBounds().pad(0.2));
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
    <section class="bg-primary text-white py-5" style="margin-top: 70px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Peta Hasil Penilaian Pemanfaatan Ruang</h1>
                    <p class="lead">Peta ini menampilkan lokasi hasil penilaian kesesuaian dan kepatuhan pemanfaatan ruang.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="peta-penilaian" class="bg-light py-5">
        <div class="container">
            <div class="row g-2">
                <div wire:ignore id="map" class="col-12" style="border: 2px solid #0d6efd;"></div>
            </div>
        </div>
    </section>
</div>
