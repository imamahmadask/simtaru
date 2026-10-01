@include('layouts.app', [
    'menuPartial' => 'layouts.menu-penilaian',
    'title' => $title ?? null,
    'slot' => $slot,
])
