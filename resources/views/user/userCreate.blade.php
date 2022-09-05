<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('user-store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Division <span class="text-danger">*</span></label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="division_id" required>
                                        <option selected>Pilih Divisi</option>
                                        @foreach ($division as $row)
                                            <option value="{{ $row->id }}">{{ $row->division_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="code" class="form-label">Pilih ADV</label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="parent_id">
                                        <option value="">Pilih ADV</option>
                                        @foreach ($adv as $row)
                                            <option value="{{ $row->user_id }}">{{ $row->nama_depan }} {{ $row->nama_belakang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" class="form-control rounded-lg"
                                        placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control rounded-lg"
                                        placeholder="email" aria-label="email" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group flex-nowrap" id="show_hide_password">
                                        <span class="input-group-text" id="addon-wrapping">
                                            <a id="basic-addon1" href=""><i class="fa fa-eye-slash"
                                                    aria-hidden="true"></i></a></span>
                                        <input type="password" class="form-control rounded-lg" name="password"
                                            placeholder="Password" aria-label="Password"
                                            aria-describedby="basic-addon1" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_depan" class="form-label">Nama Depan <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_depan" class="form-control rounded-lg"
                                                placeholder="Nama Depan" aria-label="nama_depan"
                                                aria-describedby="basic-addon1" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nama_belakang" class="form-label">Nama Belakang <span class="text-danger">*</span></label>
                                            <input type="text" name="nama_belakang" class="form-control rounded-lg"
                                                placeholder="Nama Belakang" aria-label="nama_belakang"
                                                aria-describedby="basic-addon1" required>
                                        </div>
                                    </div>
                                </div>
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <input type="text" name="alamat" class="form-control rounded-lg"
                                                placeholder="Alamat" aria-label="alamat"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Nomor HP</label>
                                            <input type="text" name="phone" class="form-control rounded-lg"
                                                placeholder="Nomor HP" aria-label="phone"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select rounded-lg" aria-label="Default select example"
                                        name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="Pria">Pria</option>
                                        <option value="Wanita">Wanita</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir"
                                                class="form-control rounded-lg" aria-label="tanggal_lahir"
                                                aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="tanggal_masuk" class="form-label">Tangal Masuk</label>
                                            <input type="date" name="tanggal_masuk"
                                                class="form-control rounded-lg" aria-label="tanggal_masuk"
                                                aria-describedby="basic-addon1">
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
