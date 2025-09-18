@extends('layouts.app')

@section('title', 'TIN Request #' . $tinRequest->id)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">TIN Request Details</h1>
        <a href="{{ route('admin.tin-requests.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to List
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- Request Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Request Information</h6>
                    <span class="badge bg-{{ 
                        $tinRequest->status === 'approved' ? 'success' : 
                        ($tinRequest->status === 'rejected' ? 'danger' : 'warning') 
                    }} text-uppercase">
                        {{ $tinRequest->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Application Details</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Request ID:</dt>
                                <dd class="col-sm-7">#{{ $tinRequest->id }}</dd>
                                
                                <dt class="col-sm-5">Submission Date:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->created_at->format('F j, Y H:i') }}</dd>
                                
                                @if($tinRequest->isApproved())
                                    <dt class="col-sm-5">TIN Number:</dt>
                                    <dd class="col-sm-7">
                                        <span class="fw-bold">{{ $tinRequest->tin_number }}</span>
                                    </dd>
                                    
                                    <dt class="col-sm-5">Approval Date:</dt>
                                    <dd class="col-sm-7">{{ $tinRequest->approved_at->format('F j, Y H:i') }}</dd>
                                    
                                    <dt class="col-sm-5">Approved By:</dt>
                                    <dd class="col-sm-7">{{ $tinRequest->approver->name ?? 'System' }}</dd>
                                    
                                    <dt class="col-sm-5">Certificate:</dt>
                                    <dd class="col-sm-7">
                                        <a href="{{ route('admin.tin-requests.certificate', $tinRequest) }}" 
                                           class="btn btn-sm btn-primary"
                                           target="_blank">
                                            <i class="fas fa-download me-1"></i> Download
                                        </a>
                                    </dd>
                                @elseif($tinRequest->isRejected())
                                    <dt class="col-sm-5">Rejection Date:</dt>
                                    <dd class="col-sm-7">{{ $tinRequest->approved_at->format('F j, Y H:i') }}</dd>
                                    
                                    <dt class="col-sm-5">Rejected By:</dt>
                                    <dd class="col-sm-7">{{ $tinRequest->approver->name ?? 'System' }}</dd>
                                    
                                    <dt class="col-sm-5">Reason for Rejection:</dt>
                                    <dd class="col-sm-7 text-danger">{{ $tinRequest->rejection_reason }}</dd>
                                @endif
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Applicant Information</h5>
                            <dl class="row">
                                <dt class="col-sm-5">Full Name:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->full_name }}</dd>
                                
                                <dt class="col-sm-5">Email:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->email }}</dd>
                                
                                <dt class="col-sm-5">Phone:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->phone ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-5">NID/Passport:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->nid_number ?? 'N/A' }}</dd>
                                
                                <dt class="col-sm-5">Date of Birth:</dt>
                                <dd class="col-sm-7">{{ $tinRequest->date_of_birth ? $tinRequest->date_of_birth->format('F j, Y') : 'N/A' }}</dd>
                                
                                <dt class="col-sm-5">Gender:</dt>
                                <dd class="col-sm-7">{{ ucfirst($tinRequest->gender) ?? 'N/A' }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Additional Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Address Information</h5>
                            <dl class="row">
                                <dt class="col-sm-3">Present Address:</dt>
                                <dd class="col-sm-9">
                                    {{ $tinRequest->present_address }},<br>
                                    {{ $tinRequest->present_city }}, {{ $tinRequest->present_zip_code }}<br>
                                    {{ $tinRequest->present_state }}, {{ $tinRequest->present_country }}
                                </dd>
                                
                                <dt class="col-sm-3">Permanent Address:</dt>
                                <dd class="col-sm-9">
                                    {{ $tinRequest->permanent_address }},<br>
                                    {{ $tinRequest->permanent_city }}, {{ $tinRequest->permanent_zip_code }}<br>
                                    {{ $tinRequest->permanent_state }}, {{ $tinRequest->permanent_country }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                    
                    <!-- Family Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="mb-3 border-bottom pb-2">Family Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">Father's Name:</dt>
                                        <dd class="col-sm-7">{{ $tinRequest->father_name ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-5">Father's NID:</dt>
                                        <dd class="col-sm-7">{{ $tinRequest->father_nid ?? 'N/A' }}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="row">
                                        <dt class="col-sm-5">Mother's Name:</dt>
                                        <dd class="col-sm-7">{{ $tinRequest->mother_name ?? 'N/A' }}</dd>
                                        
                                        <dt class="col-sm-5">Mother's NID:</dt>
                                        <dd class="col-sm-7">{{ $tinRequest->mother_nid ?? 'N/A' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Action Card -->
            @if($tinRequest->isPending())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tin-requests.approve', $tinRequest) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block" 
                                    onclick="return confirm('Are you sure you want to approve this TIN request?')">
                                <i class="fas fa-check-circle me-1"></i> Approve Request
                            </button>
                        </form>
                        
                        <button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="fas fa-times-circle me-1"></i> Reject Request
                        </button>
                        
                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.tin-requests.reject', $tinRequest) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">Reject TIN Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Please provide a reason for rejecting this TIN request:</p>
                                            <div class="mb-3">
                                                <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" 
                                                          rows="4" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times-circle me-1"></i> Confirm Rejection
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Documents Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Supporting Documents</h6>
                </div>
                <div class="card-body">
                    @if($tinRequest->documents && $tinRequest->documents->count() > 0)
                        <div class="list-group">
                            @foreach($tinRequest->documents as $document)
                                <a href="{{ route('documents.download', $document) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-file-pdf text-danger me-2"></i> {{ $document->document_type }}</span>
                                    <span class="badge bg-primary rounded-pill">
                                        {{ strtoupper(pathinfo($document->file_path, PATHINFO_EXTENSION)) }}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No supporting documents uploaded.</p>
                    @endif
                </div>
            </div>
            
            <!-- Activity Log -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Activity Log</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-plus-circle text-primary me-2"></i>
                                <span>Request Submitted</span>
                            </div>
                            <small class="text-muted">{{ $tinRequest->created_at->diffForHumans() }}</small>
                        </li>
                        
                        @if($tinRequest->isApproved() || $tinRequest->isRejected())
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <i class="fas {{ $tinRequest->isApproved() ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }} me-2"></i>
                                    <span>Request {{ ucfirst($tinRequest->status) }}</span>
                                </div>
                                <small class="text-muted">{{ $tinRequest->updated_at->diffForHumans() }}</small>
                            </li>
                            
                            @if($tinRequest->isApproved())
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="fas fa-file-certificate text-info me-2"></i>
                                        <span>TIN Certificate Generated</span>
                                    </div>
                                    <small class="text-muted">{{ $tinRequest->updated_at->diffForHumans() }}</small>
                                </li>
                            @endif
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea for rejection reason
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('rejection_reason');
        if (textarea) {
            textarea.addEventListener('focus', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush

@endsection
