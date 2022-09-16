<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Member Index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">Member List</h2>
                    </div>
                </div>
                <div class="right">
                    <a href="{{ route('member-create') }}" class="btn btn-primary">Add Member</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama CS</th>
                                    <th>Foto</th>
                                    <th>Member Nama</th>
                                    <th>Member Phone</th>
                                    <th>Member Alamat</th>
                                    <th>Tanggal Join</th>
                                    <th>Member Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($member as $key => $row)
                                    <tr>
                                        <td> {{ ++$key }} </td>
                                        <td> {{ $row->nama_depan }} {{ $row->nama_belakang }} </td>
                                        <td> <img src="{{ route('member-image', $row->image != null ? $row->image : 'kosong') }}" class="{{ $row->image != null ? 'w-20 h-20' : 'hidden' }}" alt="" title=""> <p class="{{ $row->image != null ? 'hidden' : '' }}">Data Masih kosong</p> </td>
                                        <td> {{ $row->member_name }} </td>
                                        <td> {{ $row->member_phone }} </td>
                                        <td> {{ $row->member_alamat }} </td>
                                        <td> {{ $row->join_on }} </td>
                                        <td> {{ $row->member_type == 0 ? 'Reseller' : 'Agen' }} </td>
                                        <td> {{ $row->member_status != 1 ? 'Tidak Aktif' : 'Aktif' }} </td>
                                        <td>
                                            {{-- <form action="{{ route('user-destroy', $row->user_id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{ route('user-edit', $row->user_id) }}" class="btn btn-warning mb-2"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-danger text-gray-800"><i
                                                    class="fas fa-trash"></i></button>
                                            </form> --}}
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
