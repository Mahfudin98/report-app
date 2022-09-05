<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Division Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-4 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('division-update', $division->division_code) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="code" class="form-label">Division Code</label>
                                    <input type="text" class="form-control rounded-lg" placeholder="Division Name" value="{{ $division->division_code }}" aria-label="Division Name" name="division_code" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <label for="code" class="form-label">Division Name</label>
                                    <input type="text" class="form-control rounded-lg" placeholder="Division Name" value="{{ $division->division_name }}" aria-label="Division Name" name="division_name" aria-describedby="basic-addon1" required>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-info" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
