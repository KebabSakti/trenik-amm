<x-layout>
    <x-slot:title>List Skema Kredit</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('credit_scheme.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default">
                        <table id="credit-scheme-table" class="table table-hoverr responsive nowrap" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
