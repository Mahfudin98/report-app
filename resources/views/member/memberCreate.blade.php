<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Member Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('member-store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Nama CS <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="user_id" required>
                                        <option selected>Pilih CS</option>
                                        @foreach ($cs as $row)
                                            <option value="{{ $row->user_id }}">{{ $row->nama_depan }}
                                                {{ $row->nama_belakang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="member_name" class="form-label">Nama Member <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="member_name" class="form-control rounded-lg"
                                        placeholder="Nama Member" aria-label="Nama Member"
                                        aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="member_phone" class="form-label">Nomor HP <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="member_phone" class="form-control rounded-lg"
                                        placeholder="Nomor HP" aria-label="member_phone"
                                        aria-describedby="basic-addon1" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Provinsi <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select rounded-lg provinsi" aria-label="Default select example"
                                                name="provinsi_id" required>
                                                <option value="">Pilih Provinsi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kota <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select rounded-lg kota" aria-label="Default select example"
                                                name="kota_id" required>
                                                <option value="">Pilih Kota</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kecamatan <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select rounded-lg kecamatan" aria-label="Default select example"
                                                name="district_id" required>
                                                <option value="">Pilih Kecamatan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="member_alamat" class="form-label">Member Alamat</label>
                                            <input type="text" name="member_alamat"
                                                class="form-control rounded-lg" placeholder="Member Alamat" aria-label="member_alamat"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="block mb-2 form-label" for="file_input">Upload Foto</label>
                                            <input
                                                class="form-control block w-full px-2 py-1 text-base
                                                font-normal text-gray-800 bg-white bg-clip-padding
                                                border border-solid border-gray-800 rounded transition ease-in-out m-0
                                                focus:text-gray-800 focus:bg-white focus:border-blue-600 focus:outline-none"
                                                aria-describedby="file_input_help" id="file_input" name="image"
                                                type="file">
                                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG or JPG(MAX.
                                                800x400px).</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="join_on" class="form-label">Tanggal Masuk</label>
                                            <input type="date" name="join_on"
                                                class="form-control rounded-lg" aria-label="join_on"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="member_type" class="form-label">Member Type</label>
                                            <select class="form-select rounded-lg" aria-label="Default select example"
                                                name="member_type">
                                                <option value="">Pilih Member Type</option>
                                                <option value="0">Reseller</option>
                                                <option value="1">Agen</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="flex justify-between mb-3">
                            <div class="flex">
                                <div class="shrink-0 flex items-center">
                                    <p class="mt-1 text-sm text-danger" id="file_input_help">* Wajib diisi.</p>
                                </div>
                            </div>
                            <div class="right">
                                <button class="btn btn-primary text-gray-800" type="submit">Add User</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
