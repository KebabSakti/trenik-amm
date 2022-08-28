<x-layout>
    <x-slot:title>List Barang</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('barang.index', ['display' => 'table']) }}" class="btn btn-default">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-list-details" width="28"
                height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M13 5h8"></path>
                <path d="M13 9h5"></path>
                <path d="M13 15h8"></path>
                <path d="M13 19h5"></path>
                <rect x="3" y="4" width="6" height="6" rx="1"></rect>
                <rect x="3" y="14" width="6" height="6" rx="1"></rect>
            </svg>
            List
        </a>
        <a href="{{ route('barang.index') }}" class="btn btn-default">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-grid" width="28"
                height="28" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <rect x="4" y="4" width="6" height="6" rx="1"></rect>
                <rect x="14" y="4" width="6" height="6" rx="1"></rect>
                <rect x="4" y="14" width="6" height="6" rx="1"></rect>
                <rect x="14" y="14" width="6" height="6" rx="1"></rect>
            </svg>
            Grid
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if ($display == 'table')
                        <div id="table-default" class="table-responsive">
                            <div class="table-responsive">
                                <table id="barang-table" class="table table-hover nowrap responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Brand</th>
                                            <th>Gambar</th>
                                            {{-- <th>Deskripsi</th> --}}
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="row row-cols-2 row-cols-md-4 row-cols-lg-6 g-3">
                            @foreach ($products as $product)
                                <div class="col">
                                    <div class="card">
                                        <img src="{{ asset($product->product_image) }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->product_name }}</h5>
                                            <h4 class="card-subtitle mb-3 text-muted">{{ $product->product_brand }}</h4>
                                            {{-- <p class="card-text">
                                                {{ Str::limit($product->product_description, 50, '...') }}
                                            </p> --}}
                                            <a href="{{ route('barang.show', $product->id) }}"
                                                class="btn btn-primary w-100">DETAIL</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <br>
                        <br>
                        <div class="d-flex justify-content-center">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
