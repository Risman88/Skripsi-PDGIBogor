<div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-14">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            ID Pembayaran
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nama
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Jenis Pembayaran
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Jumlah Pembayaran
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nama Bank
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nama Rekening
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nomor Rekening
                        </th>
                        @if ($show_bukti)
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Bukti Pembayaran
                        </th>
                        @endif
                        @if ($show_by)
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Dikonfirmasi Oleh
                        </th>
                        @endif
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Status
                        </th>
                        {{-- <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only"></span>
                        </th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($payments as $payment)
                        <tr class="divide-x divide-gray-200">
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->id }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->user->name }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if (strlen($payment->jenis_pembayaran) > 20)
                                    @php
                                        $jenis_pembayaran = wordwrap($payment->jenis_pembayaran, 20, '<br>');
                                    @endphp
                                    {!! $jenis_pembayaran !!}
                                @else
                                    {{ $$payment->jenis_pembayaran }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                Rp {{ number_format($payment->jumlah_pembayaran, 0, ',', '.') }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->bankAccount->nama_bank }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->bankAccount->nama_rekening }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->bankAccount->nomor_rekening }}
                            </td>
                            @if ($show_bukti)
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($payment->bukti_pembayaran)
                                    @if (pathinfo($payment->bukti_pembayaran, PATHINFO_EXTENSION) === 'pdf')
                                        <div class="flex items-center mb-4">
                                            <a href="{{ route('payments.buktipembayaran', $payment->id) }}"
                                                target="_blank" class="ml-4 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                <span class="ml-2 text-blue-500 font-medium">
                                                    Lihat PDF
                                                </span>
                                            </a>
                                        </div>
                                    @else
                                        <a href="{{ route('payments.buktipembayaran', $payment->id) }}" target="_blank">
                                            <img src="{{ route('payments.buktipembayaran', $payment->id) }}"
                                                alt="Bukti Pembayaran"
                                                class="w-40 h-auto border border-gray-300 rounded">
                                        </a>
                                    @endif
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            @endif
                            @if ($show_by)
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->updatedBy->name }}
                            </td>
                            @endif
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @can('edit pembayaran')
                                    @if ($payment->status == 'Lunas' || $payment->status == 'Belum dibayar')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $payment->status === 'Lunas' ? 'bg-green-100 text-green-800' : ($payment->status === 'Menunggu konfirmasi' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucwords($payment->status) }}
                                        </span>
                                    @else
                                    <form action="{{ route('payments.changeStatus', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="bg-white border border-gray-300 rounded text-gray-600"
                                            onchange="if (confirm('Anda yakin ingin mengubah status pembayaran menjadi \'' + this.value + '\'?')) { this.form.submit(); }">
                                            <option value="Belum dibayar" {{ $payment->status == 'Belum dibayar' ? 'selected' : '' }}
                                                onclick="event.preventDefault();">{{ $payment->status == 'Belum dibayar' ? 'Belum Dibayar' : 'Ubah ke Belum Dibayar' }}</option>
                                            <option value="Menunggu konfirmasi" {{ $payment->status == 'Menunggu konfirmasi' ? 'selected' : '' }}
                                                onclick="event.preventDefault();">{{ $payment->status == 'Menunggu konfirmasi' ? 'Menunggu Konfirmasi' : 'Ubah ke Menunggu Konfirmasi' }}</option>
                                            <option value="Lunas" {{ $payment->status == 'Lunas' ? 'selected' : '' }}
                                                onclick="event.preventDefault();">{{ $payment->status == 'Lunas' ? 'Lunas' : 'Ubah ke Lunas' }}</option>
                                        </select>
                                    </form>
                                    @endif
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $payment->status === 'Lunas' ? 'bg-green-100 text-green-800' : ($payment->status === 'Menunggu konfirmasi' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucwords($payment->status) }}
                                    </span>
                                @endcan

                            </td>
                            {{-- <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('payments.indexall', $payment->id) }}" class="text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded">
                                        Edit
                                    </a>
                                    <form action="{{ route('payments.indexall', $payment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Apakah Anda yakin ingin menghapus pembayaran ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                Tidak ada data pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="mt-4">
    {{ $payments->appends(request()->except('page'))->links() }}
</div>
