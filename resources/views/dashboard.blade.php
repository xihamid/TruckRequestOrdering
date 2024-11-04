@extends('layout.app')
@section('title', 'Home Page')
@section('content')

<div class="container-xxl">
    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i> 
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title">All Orders</h5>
        </div>
        <div class="card-body">
            @if($orders->isEmpty())
                <p>No orders found.</p> 
            @else
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }} 
                    </div>
                @endif
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Username</th> 
                            <th>Pickup Location</th>
                            <th>Delivery Location</th>
                            <th>Size/Weight</th>
                            <th>Pickup Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Order Date/Time</th>
                            <th>Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order) 
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td> 
                                <td>{{ $order->pickup_location }}</td>
                                <td>{{ $order->delivery_location }}</td>
                                <td>{{ $order->size_weight }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->pickup_datetime)->translatedFormat('j F Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->delivery_datetime)->translatedFormat('j F Y') }}</td>
                                <td>
                            @if($order->status === 'Pending')
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock-fill me-1"></i> 🕒 Pending
                                </span>
                            @elseif($order->status === 'In-Progress')
                                <span class="badge bg-info text-dark">
                                    <i class="bi bi-arrow-repeat me-1"></i> 🚧 In-Progress
                                </span>
                            @elseif($order->status === 'Delivered')
                                <span class="badge bg-success text-white">
                                    <i class="bi bi-check-circle-fill me-1"></i>✅ Delivered
                                </span>
                            @else
                                <span class="badge bg-secondary text-white">
                                    <i class="bi bi-question-circle-fill me-1"></i> Unknown
                                </span>
                            @endif
                        </td>

                                <td>{{ \Carbon\Carbon::parse($order->created_at)->translatedFormat('j F Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <div class="input-group">
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="Pending" class="bg-warning text-dark">🕒 Pending</option>
                                            <option value="In-Progress" class="bg-primary text-white">🚧 In Progress</option>
                                            <option value="Delivered" class="bg-success text-white">✅ Delivered</option>
                                        </select>
                                    </div>
                                </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection
