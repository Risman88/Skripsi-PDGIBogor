<div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-14">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            No.
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            ID Pengajuan
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nama
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Tipe Pengajuan
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Tanggal Pengajuan
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Status Pembayaran</th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Status Pengajuan
                        </th>
                        @if ($show_surat)
                            <th scope="col"
                                class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                Surat Keluar</th>
                        @endif
                        <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($submissions as $index => $submission)
                        <tr class="divide-x divide-gray-200">
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $submissions->firstItem() + $index }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $submission->id }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $submission->user->name }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $submission->submissionType->name }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $submission->created_at->format('d F Y H:i') }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($submission->payment->status === 'Lunas')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Lunas
                                    </span>
                                @elseif ($submission->payment->status === 'Menunggu Konfirmasi')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Menunggu Konfirmasi
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Belum dibayar
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($submission->status === 'Selesai')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Selesai
                                    </span>
                                @elseif ($submission->status === 'Diproses')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Diproses
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            @if ($show_surat)
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($submission->surat_keluar)
                                    @if (pathinfo($submission->surat_keluar, PATHINFO_EXTENSION) === 'pdf')
                                        <div class="flex items-center mb-4">
                                            <a href="{{ route('submission.surat_keluar', $submission->id) }}"
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
                                        <a href="{{ route('submission.surat_keluar', $submission->id) }}"
                                            target="_blank">
                                            <img src="{{ route('submission.surat_keluar', $submission->id) }}"
                                                alt="Surat Keluar" class="w-40 h-auto border border-gray-300 rounded">
                                        </a>
                                    @endif
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            @endif
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('submission.show', ['type_id' => $submission->submission_type_id, 'id' => $submission->id]) }}"
                                        class="text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded">
                                        Lihat
                                    </a>
                                    @can('edit pengajuan')
                                    <a href="{{ route('submission.edit', ['type_id' => $submission->submission_type_id, 'id' => $submission->id]) }}"
                                        class="text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded">
                                        Edit
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
