<x-layout>
    <x-slot:title>List Karyawan</x-slot:title>
    <x-slot:menu>
        <a href="{{ route('employee.create') }}" class="btn btn-primary">
            Tambah Data
        </a>
    </x-slot:menu>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div id="table-default" class="table-responsive">
                        <div class="table-responsive">
                            <table id="employee-table" class="table table-hover responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>KTP</th>
                                        <th>Telp</th>
                                        <th>Department</th>
                                        <th>Jabatan</th>
                                        <th>Grade</th>
                                        <th>Level</th>
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
    </div>
</x-layout>
