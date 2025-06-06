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
</div>
