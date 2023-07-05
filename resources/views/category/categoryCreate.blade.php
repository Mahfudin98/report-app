<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('category-store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input id="category_name" type="text" class="rounded-lg form-control" name="category_name"
                        placeholder="Category Name" aria-label="category_name" aria-describedby="basic-addon1">
                </div>
                <div class="mb-3">
                    <label for="category_type" class="form-label">Category Type</label>
                    <select id="category_type" class="rounded-lg form-select" aria-label="Default select example"
                        name="category_type">
                        <option selected>Pilih Kategori Tipe</option>
                        <option value="bpom">BPOM</option>
                        <option value="farma">Farma</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category_pay" class="form-label">Category Pay</label>
                    <select id="category_pay" class="rounded-lg form-select" aria-label="Default select example"
                        name="category_pay">
                        <option selected>Pilih Kategori Produk</option>
                        <option value="paket">Paket</option>
                        <option value="ecer">Ecer</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button class="text-white btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
