@props(['title', 'meetings'])

<div class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden mt-4 shadow-lg transition duration-300 ease-in-out dashboard-card-meetings-instance">
    <div class="absolute inset-0 bg-black bg-opacity-50 transition duration-300 ease-in-out"></div>
    <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center">
        <div>
            <div class="text-white text-lg flex space-x-2 items-center">
                <div class="bg-white rounded-md p-2 flex items-center">
                    <i class="fas fa-toggle-off fa-sm text-yellow-300"></i>
                </div>
                <p>{{ $title }}</p>
            </div>
            @if($meetings->count() > 0)
                <div class="mt-4 flex items-center">
                    <button class="text-white text-lg" id="prevBtn" onclick="prevMeeting()">&#10094;</button>
                    <div class="w-full flex overflow-x-auto" id="meetingList">
                        @foreach ($meetings as $index => $meeting)
                            <div class="w-1/3 p-2 meeting-item {{ $index >= 3 ? 'hidden' : '' }}">
                                <div class="mb-2">
                                    <span class="text-white text-sm font-bold">{{ \Carbon\Carbon::parse($meeting->start_time)->format('d F Y H:i') }}</span>
                                    <br>
                                    <span class="text-white text-sm">{{ $meeting->duration }} Menit</span>
                                    <br>
                                    <a href="{{ $meeting->link_zoom }}" class="text-blue-700 text-sm hover:underline" target="_blank">Link Zoom</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="text-white text-lg" id="nextBtn" onclick="nextMeeting()">&#10095;</button>
                </div>
            @else
                <div class="mt-4 text-white text-lg">
                    Tidak ada jadwal wawancara
                </div>
            @endif
        </div>
    </div>
</div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const instances = document.querySelectorAll('.dashboard-card-meetings-instance');

    instances.forEach((instance) => {
        let currentIndex = 0;
        const meetingItems = instance.querySelectorAll('.meeting-item');

        function showMeetings() {
            meetingItems.forEach((item, index) => {
                if (index >= currentIndex && index < currentIndex + 3) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        }

        function prevMeeting() {
            if (currentIndex > 0) {
                currentIndex -= 1;
                showMeetings();
            }
        }

        function nextMeeting() {
            if (currentIndex + 3 < meetingItems.length) {
                currentIndex += 1;
                showMeetings();
            }
        }

        const prevBtn = instance.querySelector('#prevBtn');
        const nextBtn = instance.querySelector('#nextBtn');

        prevBtn.addEventListener('click', prevMeeting);
        nextBtn.addEventListener('click', nextMeeting);
    });
});
    </script>
