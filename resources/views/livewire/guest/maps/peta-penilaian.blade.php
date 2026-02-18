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
                                    <hr class="my-2">
                                    <a href="javascript:void(0)" onclick="openFeedbackModal(${loc.id})" class="text-primary fw-bold"><i class="bi bi-chat-left-text me-1"></i>Beri Masukan</a>
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

            window.openFeedbackModal = (id) => {
                @this.openSaranModal(id);
            };

            Livewire.on('open-modal-saran', () => {
                const modalElement = document.getElementById('modalSaran');
                if (modalElement) {
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (!modalInstance) {
                        modalInstance = new bootstrap.Modal(modalElement);
                    }
                    modalInstance.show();
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
@endpush

<div>
    <section class="bg-primary text-white py-5" style="margin-top: 70px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3">Peta Penilaian KKPR dan PMP UMK</h1>
                    <p class="lead">Peta ini menampilkan hasil penilaian KKPR dan PMP UMK yang telah dilakukan di Kota Mataram.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="peta-penilaian" class="bg-light py-5">
        <div class="container">
            <!-- Filter Section -->
            <div class="row justify-content-center mb-4 g-3">
                <div class="col-md-3">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-calendar-event text-primary"></i></span>
                        <select wire:model="filterYear" class="form-select border-start-0" aria-label="Filter Tahun">
                            <option value="" selected>Tahun Penilaian</option>
                            <option value="2026">2026</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white border-end-0"><i
                                class="bi bi-tag text-primary"></i></span>
                        <select wire:model="filterJenis" class="form-select border-start-0" aria-label="Filter Jenis Penilaian">
                            <option value="" selected>Jenis Penilaian</option>                            
                            <option value="KKPR/KKKPR">KKPR/KKKPR</option>
                            <option value="PMP UMK">PMP UMK</option>
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
                <div wire:ignore id="map" class="col-12" style="border: 2px solid #0d6efd;"></div>
            </div>
        </div>

        <!-- Modal Saran/Masukan -->
        <div wire:ignore.self class="modal fade" id="modalSaran" tabindex="-1" aria-labelledby="modalSaranLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalSaranLabel">Beri Saran / Masukan Penilaian</h5>
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
                                <textarea class="form-control @error('saranPesan') is-invalid @enderror" id="saranPesan" wire:model="saranPesan" rows="4" placeholder="Tuliskan saran atau masukan Anda terkait penilaian ini"></textarea>
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
    </section>
</div>
