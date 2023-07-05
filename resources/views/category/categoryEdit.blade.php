<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Category Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="row">
                <div class="mx-auto col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('category-update', $category->category_code) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="category_code" class="form-label">Category Code</label>
                                    <input id="category_code" type="text" value="{{ $category->category_code }}"
                                        class="rounded-lg form-control" name="category_code" placeholder="Category Name"
                                        aria-label="category_name" aria-describedby="basic-addon1">
                                </div>
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Category Name</label>
                                    <input id="category_name" type="text" value="{{ $category->category_name }}"
                                        class="rounded-lg form-control" name="category_name" placeholder="Category Name"
                                        aria-label="category_name" aria-describedby="basic-addon1">
                                </div>
                                <div class="mb-3">
                                    <label for="category_type" class="form-label">Category Type</label>
                                    <select id="category_type" class="rounded-lg form-select"
                                        aria-label="Default select example" name="category_type">
                                        <option selected>Pilih Kategori Tipe</option>
                                        <option value="bpom"
                                            {{ $category->category_type == 'bpom' ? 'selected' : '' }}>BPOM</option>
                                        <option value="farma"
                                            {{ $category->category_type == 'farma' ? 'selected' : '' }}>Farma</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category_pay" class="form-label">Category Pay</label>
                                    <select id="category_pay" class="rounded-lg form-select"
                                        aria-label="Default select example" name="category_pay">
                                        <option selected>Pilih Kategori Produk</option>
                                        <option value="paket"
                                            {{ $category->category_pay == 'paket' ? 'selected' : '' }}>
                                            Paket
                                        </option>
                                        <option value="ecer"
                                            {{ $category->category_pay == 'ecer' ? 'selected' : '' }}>
                                            Ecer
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button class="text-white btn btn-info">Edit Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
