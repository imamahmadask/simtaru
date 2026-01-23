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
                                `<b>${loc.name}</b><br>${loc.info}<br>${loc.alamat}<br>${loc.kelurahan}<br>${loc.kecamatan}<br>${loc.jenis_kegiatan}<br>${loc.kesimpulan}<hr><a href="javascript:void(0)" onclick="openFeedbackModal(${loc.id})" class="text-primary fw-bold"><i class="bi bi-chat-left-text me-1"></i>Beri Masukan</a>`
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

            window.openFeedbackModal = (id) => {
                @this.openSaranModal(id);
            };

            Livewire.on('open-modal-saran', () => {
                const modalElement = document.getElementById('modalSaran');
                if (modalElement) {
                    if (typeof bootstrap !== 'undefined') {
                        let modalInstance = bootstrap.Modal.getInstance(modalElement);
                        if (!modalInstance) {
                            modalInstance = new bootstrap.Modal(modalElement);
                        }
                        modalInstance.show();
                    } else {
                        console.error('Bootstrap is not defined. Modal cannot be shown.');
                    }
                } else {
                    console.error('Modal element #modalSaran not found');
                }
            });

            Livewire.on('close-modal-saran', () => {
                const modalElement = document.getElementById('modalSaran');
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            });

            Livewire.on('show-success-toast', () => {
                setTimeout(() => {
                    const toast = document.getElementById('successToast');
                    if (toast) {
                        const bsAlert = new bootstrap.Alert(toast);
                        bsAlert.close();
                    }
                }, 5000);
            });
        });
    </script>

    <div wire:ignore class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-4 fw-bold text-dark mb-4">Peta Digital Interaktif</h2>
                <p class="lead text-muted">
                    Peta Informasi Pemanfaatan Ruang Kota Mataram
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
                    <input type="text" wire:model="pemanfaatan_ruang" class="form-control border-start-0 border-end-0"
                        placeholder="Cari Pemanfaatan Ruang">
                    <button class="btn bg-white border-start-0 text-muted" type="button" x-show="$wire.pemanfaatan_ruang"
                        wire:click="$set('pemanfaatan_ruang', '')">
                        <i class="bi bi-x-lg"></i>
                    </button>
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

    <!-- Modal Saran/Masukan -->
    <div wire:ignore.self class="modal fade" id="modalSaran" tabindex="-1" aria-labelledby="modalSaranLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalSaranLabel">Beri Saran / Masukan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click="closeSaranModal"></button>
                </div>
                <form wire:submit.prevent="saveSaran">
                    <div class="modal-body">
                        @if ($successMessage)
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ $successMessage }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="saranNama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('saranNama') is-invalid @enderror" id="saranNama" wire:model="saranNama" placeholder="Masukkan nama Anda">
                            @error('saranNama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="saranPesan" class="form-label">Saran / Masukan</label>
                            <textarea class="form-control @error('saranPesan') is-invalid @enderror" id="saranPesan" wire:model="saranPesan" rows="4" placeholder="Tuliskan saran atau masukan Anda terkait permohonan ini"></textarea>
                            @error('saranPesan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeSaranModal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-1"></i> Kirim Masukan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($successMessage)
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1060">
        <div id="successToast" class="alert alert-success shadow-lg alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" wire:click="$set('successMessage', null)"></button>
        </div>
    </div>
    @endif
</div>
