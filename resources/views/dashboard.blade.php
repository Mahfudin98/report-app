<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between mb-3">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <h2 class="font-semibold text-lg text-gray-800 leading-tight">Activity List</h2>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date Time</th>
                                    <th>Activity</th>
                                    <th>URL</th>
                                    <th>Method</th>
                                    <th>Ip</th>
                                    <th width="300px">User Agent</th>
                                    <th>User Id</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($logs as $key => $log)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $log->date_time }}</td>
                                        <td>{{ $log->activity }}</td>
                                        <td class="text-success">{{ $log->url }}</td>
                                        <td><label class="label label-info">{{ $log->method }}</label></td>
                                        <td class="text-warning">{{ $log->ip }}</td>
                                        <td class="text-danger">{{ $log->browser }}</td>
                                        <td>{{ $log->user_id }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
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
</x-app-layout>
