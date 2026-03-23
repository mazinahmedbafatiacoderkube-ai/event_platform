@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <h2 class="mb-4">Staff Management</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Create Staff Form --}}
        <div class="card mb-4">
            <div class="card-body">

                <h4>Add Event Manager</h4>

                <form method="POST" action="{{ route('staff.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                        </div>

                        <div class="col-md-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="col-md-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="col-md-3">
                            <button class="btn btn-success">
                                Create Staff
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        {{-- Staff List --}}
        <div class="card mb-4">
            <div class="card-body">
                <h4>Staff List</h4>

                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($staff as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->role }}</td>
                                <td>
                                    @if($member->id !== auth()->id())
                                        <form action="{{ route('staff.delete', $member->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this staff member?')">Delete</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Owner</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Staff Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        {{-- Event-Specific Chat for Staff --}}
        <hr class="mt-4">
        <h4>💬 Event Chat (Staff)</h4>

        <select id="staff-event-select" class="form-control mb-2">
            <option value="">Select Event</option>
            @foreach($events as $event)
                <option value="{{ $event->id }}">{{ $event->title }}</option>
            @endforeach
        </select>

        <div id="staff-chat-box"
            style="height:250px; overflow-y:auto; border:1px solid #ccc; padding:10px; background:#f9f9f9;"></div>

        <div class="d-flex mt-2">
            <input type="text" id="staff-message-input" class="form-control" placeholder="Type your message...">
            <button onclick="sendStaffMessage()" class="btn btn-primary ms-2">Send</button>
        </div>

    </div>

@endsection

@section('scripts')
    <script>
        // Single declaration for current user
        const currentUserId = {!! auth()->id() ?? 0 !!};

        function renderMessage(msg) {
            const senderId = msg.user_id ?? null;
            const isMine = Number(senderId) === Number(currentUserId);

            return `
                <div style="display:flex; justify-content:${isMine ? 'flex-end' : 'flex-start'}">
                    <div style="background:${isMine ? 'blue' : 'gray'}; color:white; padding:10px; margin:5px; max-width:80%;">
                        ${msg.message}
                    </div>
                </div>
            `;
        }

        let staffEventId = null;
        const staffChatBox = document.getElementById('staff-chat-box');

        document.getElementById('staff-event-select').addEventListener('change', function () {

            staffEventId = this.value;
            staffChatBox.innerHTML = '';

            if (!staffEventId) return;

            // Fetch previous messages
            fetch(`/events/${staffEventId}/messages`)
                .then(res => res.json())
                .then(data => {
                    data.reverse().forEach(msg => {
                        staffChatBox.innerHTML += renderMessage(msg);
                    });
                    staffChatBox.scrollTop = staffChatBox.scrollHeight;
                });

            // Leave other channels
            window.Echo.leaveAllChannels();

            // Listen for new messages
            window.Echo.channel(`event.${staffEventId}`)
                .listen('MessageSent', (e) => {
                    staffChatBox.innerHTML += renderMessage(e.message);
                    staffChatBox.scrollTop = staffChatBox.scrollHeight;
                });
        });

        function sendStaffMessage() {
            const input = document.getElementById('staff-message-input');
            if (!staffEventId || input.value.trim() === '') return;

            fetch(`/events/${staffEventId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: input.value })
            });

            input.value = '';
        }
    </script>
@endsection