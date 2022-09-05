<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">User List</h2>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('user-create') }}" class="btn btn-primary">Add User</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Divisi Code</th>
                                    <th>Divisi Nama</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Nomor HP</th>
                                    <th>Alamat</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($user as $key => $row)
                                    <tr>
                                        <td> {{ ++$key }} </td>
                                        <td> {{ $row->division_code }} </td>
                                        <td> {{ $row->division_name }} </td>
                                        <td> <img src="{{ route('user-image', $row->image != null ? $row->image : 'kosong') }}" class="{{ $row->image != null ? '' : 'hidden' }}" alt="" title=""> <p class="{{ $row->image != null ? 'hidden' : '' }}">Data Masih kosong</p> </td>
                                        <td> {{ $row->nama_depan }} {{ $row->nama_belakang }} </td>
                                        <td> {{ $row->jenis_kelamin != null ? $row->jenis_kelamin : 'Belum ada Data' }} </td>
                                        <td> {{ $row->email }} </td>
                                        <td> {{ $row->phone != null ? $row->phone : 'Belum ada Data' }} </td>
                                        <td> {{ $row->alamat != null ? $row->alamat : 'Belum ada Data' }} </td>
                                        <td> {{ $row->tanggal_lahir != null ? $row->tanggal_lahir : 'Belum ada Data' }} </td>
                                        <td> {{ $row->tanggal_masuk != null ? $row->tanggal_masuk : 'Belum ada Data' }} </td>
                                        <td> {{ $row->tanggal_keluar != null ? $row->tanggal_keluar : 'Belum ada Data' }} </td>
                                        <td> {{ $row->status }} </td>
                                        <td>
                                            <form action="{{ route('user-destroy', $row->user_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('user-edit', $row->user_id) }}" class="btn btn-warning mb-2"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger text-gray-800"><i
                                                    class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12">
                                            <p
                                                class="text-center mb-5 mt-5 font-semibold text-base leading-tight text-gray-800">
                                                Data Masih Kosong</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
