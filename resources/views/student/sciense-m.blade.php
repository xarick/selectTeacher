<x-app-layout>
    <div class="max-w-7xl mx-auto px-2 py-4">
        <div class="bg-white border-b border-gray-200 p-6 overflow-hidden rounded">
            <div class="relative overflow-x-auto">
                <div class="py-4 px-2 flex align-middle justify-between">
                    <div>
                        <form method="get">
                            <label for="table-search" class="sr-only">Qidirish</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" id="table-search" name="name" value="{{ request('name') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2"
                                    placeholder="номи">
                            </div>
                        </form>
                    </div>
                    <div class="my-auto">
                        {{-- <a href="{{ route('ad.holiday.create') }}"
                            class="text-white bg-violet-700 hover:bg-violet-800 font-medium rounded text-sm px-4 py-2">
                            Қўшиш
                        </a> --}}
                    </div>
                </div>
                <div class="mx-2">
                    @include('library.alerts')
                </div>
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Fan va o'qituvchi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Guruh
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Холати
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($scienses as $item)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $item->tts->teacher->last_name }}
                                    {{ $item->tts->teacher->first_name }}
                                    ({{ $item->tts->sciense->name }})
                                </th>
                                <td class="px-6 py-4">
                                    {{ $item->group->name }}
                                </td>
                                <td class="px-6 py-4">
                                    @if ($item->active)
                                        <span
                                            class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                            Aктив
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                                            Aктив емас
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="m-4">
                    {{ $scienses->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
