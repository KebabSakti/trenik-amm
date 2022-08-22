<x-layout>
    <x-slot:title>List product</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('product.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default">
                        <table id="product-table" class="table table-hoverr responsive nowrap" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Barang</th>
                                    <th>Merk</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
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
