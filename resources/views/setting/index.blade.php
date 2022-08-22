<x-layout>
    <x-slot:title>List Grade</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('grade.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table id="grade-table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Grade</th>
                                        <th>Limit Pinjaman</th>
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
