@include('layouts.app', [
    'menuPartial' => 'layouts.menu-pelanggaran',
    'title' => $title ?? null,
    'slot' => $slot,
])
