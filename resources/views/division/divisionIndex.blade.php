<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Division Index') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                @include('division.divisionCreate')
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Division Code</th>
                                            <th>Division Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($division as $key => $row)
                                            <tr>
                                                <td> {{ ++$key }} </td>
                                                <td> {{ $row->division_code }} </td>
                                                <td> {{ $row->division_name }} </td>
                                                <td> <a class="btn btn-warning" href="{{ route('division-edit', $row->division_code) }}" role="button"><i class="fas fa-edit"></i></a> </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <p class="text-center mb-5 mt-5 font-semibold text-base leading-tight text-gray-800">Data Masih Kosong</p>
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
        </div>
    </div>
</x-app-layout>
