<x-layout>
    <x-slot:title>List Department</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('department.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table id="department-table" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Department</th>
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
