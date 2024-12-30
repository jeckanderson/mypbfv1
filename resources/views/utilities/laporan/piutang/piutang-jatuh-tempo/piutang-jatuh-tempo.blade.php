@extends('layout.main')

@section('main')
    <div class="flex items-center mt-8 intro-y">
        <h2 class="mr-auto text-lg text-primary font-medium">
            Lap. Piutang Jatuh Tempo
        </h2>
    </div>
    <livewire:utilities.piutang.tempo-piutang />
@endsection
