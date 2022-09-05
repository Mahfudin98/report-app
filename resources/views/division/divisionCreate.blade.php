<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('division-store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Division Name</label>
                    <input type="text" class="form-control rounded-lg" placeholder="Division Name" aria-label="Division Name" name="division_name" aria-describedby="basic-addon1" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-info" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
