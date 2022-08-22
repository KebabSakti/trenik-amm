<x-layout>
    <x-slot:title>List Jabatan</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('jabatan.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table id="jabatan-table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Jabatan</th>
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
    </div>
</x-layout>
