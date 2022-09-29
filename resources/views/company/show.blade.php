<x-layout>
    <x-slot:title>Syarat dan Ketentuan</x-slot:title>

    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 md-6">
                            {!! nl2br($company->tc) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
