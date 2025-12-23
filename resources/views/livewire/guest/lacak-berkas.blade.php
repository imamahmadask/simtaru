<div>
    <style>
        .timeline {
            border-left: 1px solid hsl(0, 0%, 90%);
            position: relative;
            list-style: none;
        }

        .timeline .timeline-item {
            position: relative;
        }

        .timeline .timeline-item:after {
            position: absolute;
            display: block;
            top: 5px;
        }

        .timeline .timeline-item:after {
            background-color: hsl(0, 0%, 90%);
            left: -38px;
            border-radius: 50%;
            height: 11px;
            width: 11px;
            content: "";
        }
    </style>

    <form wire:submit.prevent="lacakBerkas">
        <div class="input-group input-group-lg shadow-sm">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-muted"></i>
            </span>
            <input type="text" wire:model="no_reg" class="form-control border-start-0 ps-0" 
                placeholder="Masukkan Nomor Registrasi untuk melacak berkas..." 
                aria-label="Nomor Registrasi">
            <button class="btn btn-primary px-4 fw-bold" type="submit" wire:loading.attr="disabled" 
            data-bs-toggle="modal" data-bs-target="#showModalDetailRegistrasi">
                Cari
                <div wire:loading class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </button>
        </div>
    </form>

    <div wire:ignore.self class="modal fade" id="showModalDetailRegistrasi" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">
                        Riwayat Berkas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="row">                            
                        <div class="col-md-12 col-lg-12 ps-md-5 mt-5 mt-md-0">                    
                            @if($riwayats)
                                <section class="p-2 mt-2" style="max-height: 470px; overflow-y: auto;">
                                    <ul class="timeline">
                                        @foreach ($riwayats as $riwayat)
                                            <li class="timeline-item mb-3">
                                                <small class="text-muted">
                                                    {{ date('j F Y h:i:s', strtotime($riwayat->created_at)) }}
                                                </small>
                                                <h5 class="fw-semibold fs-6 mb-1">{{ $riwayat->keterangan }}</h5>
                                                <p class="text-muted">
                                                    Oleh : {{ $riwayat->user->name }}
                                                </p>
                                            </li>
                                        @endforeach                                    
                                    </ul>
                                </section>   
                            @else
                                <p class="text-center">Data tidak ditemukan</p>    
                            @endif
                        </div>                 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
