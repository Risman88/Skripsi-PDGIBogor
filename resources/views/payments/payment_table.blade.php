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
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Bukti Pembayaran
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($payments as $payment)
                        <tr class="divide-x divide-gray-200">
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->id }}
                            </td>
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
                                {{ $payment->nama_bank }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->nama_rekening }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $payment->nomor_rekening }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($payment->status === 'Belum dibayar')
                                <form action="{{ route('payments.upload', $payment->id) }}" method="POST" enctype="multipart/form-data" id="formPayment_{{ $payment->id }}">
                                    @csrf
                                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran_{{ $payment->id }}" class="hidden" onchange="confirmUpload({{ $payment->id }})">
                                    <button type="button" class="text-blue-600 hover:text-blue-800" onclick="document.getElementById('bukti_pembayaran_{{ $payment->id }}').click();">
                                        Upload Bukti Pembayaran
                                    </button>
                                </form>
                                <script>
                                    function confirmUpload(id) {
                                        if (confirm('Apakah Anda yakin ingin mengupload bukti pembayaran ini?')) {
                                            document.getElementById('formPayment_'+id).submit();
                                        } else {
                                            // Reset input file jika pengguna membatalkan konfirmasi
                                            document.getElementById('bukti_pembayaran_'+id).value = '';
                                        }
                                    }
                                </script>
                                @elseif ($payment->status === 'Menunggu konfirmasi' || $payment->status === 'Lunas')
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
                                        <a href="{{ route('payments.buktipembayaran', $payment->id) }}"
                                            target="_blank">
                                            <img src="{{ route('payments.buktipembayaran', $payment->id) }}"
                                                alt="Bukti Pembayaran"
                                                class="w-40 h-auto border border-gray-300 rounded">
                                        </a>
                                    @endif
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $payment->status === 'Lunas' ? 'bg-green-100 text-green-800' : ($payment->status === 'Menunggu konfirmasi' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucwords($payment->status) }}
                                </span>
                            </td>
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
