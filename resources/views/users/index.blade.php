@extends('layout.app')
@section('title', 'Users List')

@section('content')
<div class="container-xxl">
   

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title">All Users</h5>
        </div>
        <div class="card-body">
            @if($users->isEmpty())
                <p>No users found.</p>
            @else
                <table class="table align-middle table-nowrap mb-0">
                    <thead>
                    <tr>
                        <td>Name</td>
                        <td>Type</td>
                        <td>Mobile</td>
                        <td>Address</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            @if(auth()->user()->id === $user->id)
                                @continue
                            @endif
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary rounded p-1 me-3 align-items-center justify-content-center d-flex">
                                            <i class="mdi mdi-account-circle fs-20 text-white"></i>
                                        </div>
                                        <div>
                                            <h5 class="fs-14 my-1">{{ $user->name }}</h5>
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="fs-14 my-1 fw-normal">{{ $user->user_type ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <p class="fs-14 my-1 fw-normal">{{ $user->mobile ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <p class="fs-14 my-1 fw-normal">{{ $user->address ?? 'N/A' }}</p>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-end">
                                        <button type="button" class="btn btn-primary btn-sm w-100 mb-2 send-email" data-user-id="{{ $user->id }}" data-user-email="{{ $user->email }}">
                                            <i class="mdi mdi-email-outline"></i> Send Email
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm w-100 view-history" data-user-id="{{ $user->id }}">
                                            <i class="mdi mdi-history"></i> View Email History
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Modal for sending email -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="emailForm" action="{{ route('users.sendEmail') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="userId">
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for viewing email history -->
    <div class="modal fade" id="emailHistoryModal" tabindex="-1" aria-labelledby="emailHistoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="emailHistoryModalLabel">Email History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <ul id="emailHistoryBody" class="list-group">
                        <div class="alert alert-info">Loading email history...</div>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function() {
    // Handle sending email
    $('.send-email').on('click', function() {
        var userId = $(this).data('user-id');
        $('#userId').val(userId);
        $('#emailModal').modal('show');
    });

    // Handle viewing email history
    $('.view-history').on('click', function() {
        var userId = $(this).data('user-id');
        
        // Clear previous data
        $('#emailHistoryBody').html('<div class="alert alert-info">Loading email history...</div>');

        // Fetch email history
        $.ajax({
            url: '/users/' + userId + '/email-history',
            method: 'GET',
            success: function(emails) {
                $('#emailHistoryBody').empty(); // Clear loading message
                if (emails.length === 0) {
                    $('#emailHistoryBody').html('<div class="alert alert-warning">No emails found.</div>');
                } else {
                    // Create a simple list format for the emails
                    $.each(emails, function(index, email) {
                        $('#emailHistoryBody').append(`
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <strong>${email.subject}</strong><br>
                                        <span class="text-muted">${email.message}</span>
                                    </div>
                                    <small class="text-muted">${new Date(email.created_at).toLocaleString()}</small>
                                </div>
                            </li>
                        `);
                    });
                }
                $('#emailHistoryModal').modal('show');
            },
            error: function() {
                $('#emailHistoryBody').html('<div class="alert alert-danger">Error loading emails.</div>');
            }
        });
    });
});
</script>
@endsection
