@extends('layouts.admin')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Users Subscription Manager</h2>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Subscription
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped" id="subscriptions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Phone No</th>
                    <th>Email</th>
                    <th>Invoice No</th>
                    <th>Product</th>
                    <th>Package / Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subscriptions as $sub)
                <tr>
                    <td>{{ $sub->id }}</td>
                    <td>
                        {{ $sub->user->name ?? ($sub->customer_name ?? ($sub->order->customer_name ?? 'N/A')) }}
                        @if(!$sub->user_id) <span class="badge badge-light" style="font-size: 0.7em;">Manual</span> @endif
                    </td>
                    <td>
                        {{ $sub->customer_phone ?? ($sub->order->customer_phone ?? 'N/A') }} 
                    </td>
                    <td>
                        {{ $sub->user->email ?? ($sub->customer_email ?? ($sub->order->customer_email ?? 'N/A')) }}
                    </td>
                    <td>
                        {{ $sub->order_id ?? 'N/A' }}
                    </td>
                    <td>
                        {{ $sub->product->title ?? '-' }}
                    </td>
                    <td>
                        {{ $sub->plan->name ?? '-' }}
                    </td>
                    <td>{{ $sub->start_date->format('Y-m-d') }}</td>
                    <td>{{ $sub->end_date->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge {{ $sub->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 0.5rem;">
                            <form action="{{ route('admin.subscriptions.notify', $sub->id) }}" method="POST" onsubmit="return confirm('Send WhatsApp reminder?');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Send WhatsApp Reminder"><i class="fab fa-whatsapp"></i></button>
                            </form>
                            <a href="{{ route('admin.subscriptions.edit', $sub->id) }}" class="btn btn-sm btn-info" style="color:white;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.subscriptions.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#subscriptions-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });

    @if(session('whatsapp_url'))
        window.open("{!! session('whatsapp_url') !!}", "_blank");
    @endif
</script>
@endsection
