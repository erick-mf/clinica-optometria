@props(['headers' => [], 'rows' => [], 'paginator' => null])

<div class="overflow-hidden bg-white rounded-xl shadow-sm border border-gray-100">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gradient-to-r from-gray-50 to-indigo-50">
            <tr>
                @foreach ($headers as $key => $header)
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @if ($rows->isEmpty())
                <tr>
                    <td colspan="{{ count($headers) }}" class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="text-gray-500">No hay datos disponibles</div>
                    </td>
                </tr>
            @else
                @foreach ($rows as $row)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        @foreach ($headers as $key => $header)
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    @if (isset($row[$key]))
                                        {{ $row[$key] }}
                                    @elseif (isset($row->$key))
                                        {{ $row->$key }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

@if ($paginator)
    <x-custom-pagination :paginator="$paginator" />
@endif
