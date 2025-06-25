<div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Tutors</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tutors as $tutor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $tutor->id }}">{{ $tutor->name }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Upcoming Sessions</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($upcomingSessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $session->tutor->id }}">{{ $session->tutor->name }}</a></td>
                            <td>{{ $session->start_time->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="p-5 flex flex-col gap-4">
        <h2 class="text-2xl font-semibold">Past Sessions</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pastSessions as $session)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><a href="/profile/{{ $session->tutor->id }}">{{ $session->tutor->name }}</a></td>
                            <td>{{ $session->start_time->format('d/m/Y') }}</td>
                            <td>{{ $session->start_time->format('H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
