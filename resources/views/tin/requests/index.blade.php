@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">TIN Requests</h4>
                    @can('create', App\Models\TinRequest::class)
                        <a href="{{ route('tin-requests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> New TIN Request
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if (session('info'))
                        <div class="alert alert-info" role="alert">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Applicant</th>
                                    <th>NID</th>
                                    <th>Status</th>
                                    <th>Requested On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div>{{ $request->full_name }}</div>
                                            <small class="text-muted">{{ $request->email }}</small>
                                        </td>
                                        <td>{{ $request->nid_number }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $request->status === 'approved' ? 'success' : 
                                                ($request->status === 'rejected' ? 'danger' : 'warning') 
                                            }} text-uppercase">
                                                {{ $request->status }}
                                            </span>
                                            @if($request->isApproved())
                                                <div class="small text-muted">TIN: {{ $request->tin_number }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('tin-requests.show', $request) }}" 
                                               class="btn btn-sm btn-outline-primary"
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            @can('delete', $request)
                                                @if($request->isPending())
                                                    <form action="{{ route('tin-requests.destroy', $request) }}" 
                                                          method="POST" class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this request?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">No TIN requests found.</div>
                                            @can('create', App\Models\TinRequest::class)
                                                <a href="{{ route('tin-requests.create') }}" class="btn btn-primary mt-2">
                                                    <i class="fas fa-plus me-1"></i> Create New Request
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($requests->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $requests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
