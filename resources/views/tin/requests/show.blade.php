@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">TIN Application Details</h4>
                    <span class="badge bg-{{ 
                        $request->status === 'approved' ? 'success' : 
                        ($request->status === 'rejected' ? 'danger' : 'warning') 
                    }} text-uppercase">
                        {{ $request->status }}
                    </span>
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

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Application Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Application ID:</dt>
                                <dd class="col-sm-8">{{ $request->id }}</dd>
                                
                                <dt class="col-sm-4">Application Date:</dt>
                                <dd class="col-sm-8">{{ $request->created_at->format('F j, Y') }}</dd>
                                
                                @if($request->isApproved())
                                    <dt class="col-sm-4">TIN Number:</dt>
                                    <dd class="col-sm-8">
                                        <span class="fw-bold">{{ $request->tin_number }}</span>
                                    </dd>
                                    
                                    <dt class="col-sm-4">Approval Date:</dt>
                                    <dd class="col-sm-8">{{ $request->approved_at->format('F j, Y') }}</dd>
                                    
                                    <dt class="col-sm-4">Approved By:</dt>
                                    <dd class="col-sm-8">{{ $request->approver->name ?? 'System' }}</dd>
                                @elseif($request->isRejected())
                                    <dt class="col-sm-4">Rejection Date:</dt>
                                    <dd class="col-sm-8">{{ $request->approved_at->format('F j, Y') }}</dd>
                                    
                                    <dt class="col-sm-4">Rejected By:</dt>
                                    <dd class="col-sm-8">{{ $request->approver->name ?? 'System' }}</dd>
                                    
                                    <dt class="col-sm-4">Reason:</dt>
                                    <dd class="col-sm-8 text-danger">{{ $request->rejection_reason }}</dd>
                                @endif
                            </dl>
                            
                            @if($request->isApproved() && $request->certificate_path)
                                <div class="mt-4">
                                    <h5 class="mb-3 border-bottom pb-2">TIN Certificate</h5>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Your TIN certificate is ready. You can download it using the button below.
                                    </div>
                                    
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tin-requests.download-certificate', $request) }}" class="btn btn-primary">
                                            <i class="fas fa-download me-1"></i> Download Certificate (PDF)
                                        </a>
                                        
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#certificatePreviewModal">
                                            <i class="fas fa-eye me-1"></i> Preview Certificate
                                        </button>
                                    </div>
                                    
                                    <div class="mt-3 text-muted small">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Please save this certificate for your records. You'll need it for tax-related activities.
                                    </div>
                                </div>
                                
                                <!-- Certificate Preview Modal -->
                                <div class="modal fade" id="certificatePreviewModal" tabindex="-1" aria-labelledby="certificatePreviewModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="certificatePreviewModalLabel">TIN Certificate Preview</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-0">
                                                <iframe 
                                                    src="{{ route('tin-requests.download-certificate', $request) }}#toolbar=0&navpanes=0" 
                                                    style="width: 100%; height: 70vh; border: none;">
                                                </iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="{{ route('tin-requests.download-certificate', $request) }}" class="btn btn-primary">
                                                    <i class="fas fa-download me-1"></i> Download
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            @can('update', $request)
                                @if($request->isPending())
                                    <div class="mt-4">
                                        <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#approveModal">
                                            <i class="fas fa-check me-1"></i> Approve
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                            <i class="fas fa-times me-1"></i> Reject
                                        </button>
                                    </div>
                                @endif
                            @endcan
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Applicant Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Full Name:</dt>
                                <dd class="col-sm-8">{{ $request->full_name }}</dd>
                                
                                <dt class="col-sm-4">Email:</dt>
                                <dd class="col-sm-8">{{ $request->email }}</dd>
                                
                                <dt class="col-sm-4">Phone:</dt>
                                <dd class="col-sm-8">{{ $request->phone }}</dd>
                                
                                <dt class="col-sm-4">NID Number:</dt>
                                <dd class="col-sm-8">{{ $request->nid_number }}</dd>
                                
                                <dt class="col-sm-4">Date of Birth:</dt>
                                <dd class="col-sm-8">{{ $request->date_of_birth->format('F j, Y') }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Family Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Father's Name:</dt>
                                <dd class="col-sm-8">{{ $request->father_name }}</dd>
                                
                                <dt class="col-sm-4">Mother's Name:</dt>
                                <dd class="col-sm-8">{{ $request->mother_name }}</dd>
                                
                                @if($request->spouse_name)
                                    <dt class="col-sm-4">Spouse's Name:</dt>
                                    <dd class="col-sm-8">{{ $request->spouse_name }}</dd>
                                @endif
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Address Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Present Address:</dt>
                                <dd class="col-sm-8">{{ nl2br(e($request->present_address)) }}</dd>
                                
                                <dt class="col-sm-4">Permanent Address:</dt>
                                <dd class="col-sm-8">{{ nl2br(e($request->permanent_address)) }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Employment Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Occupation:</dt>
                                <dd class="col-sm-8">{{ $request->occupation }}</dd>
                                
                                @if($request->company_name)
                                    <dt class="col-sm-4">Company/Business:</dt>
                                    <dd class="col-sm-8">{{ $request->company_name }}</dd>
                                    
                                    @if($request->company_address)
                                        <dt class="col-sm-4">Company Address:</dt>
                                        <dd class="col-sm-8">{{ nl2br(e($request->company_address)) }}</dd>
                                    @endif
                                @endif
                            </dl>
                        </div>
                        
                        <div class="col-md-6">
                            <h5 class="mb-3 border-bottom pb-2">Additional Information</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Purpose:</dt>
                                <dd class="col-sm-8">{{ $request->purpose }}</dd>
                            </dl>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('tin-requests.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Back to List
                        </a>
                        
                        @if($request->isPending() && $request->user_id === auth()->id())
                            <form action="{{ route('tin-requests.destroy', $request) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this TIN request?')">
                                    <i class="fas fa-trash me-1"></i> Cancel Request
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@can('update', $request)
<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel">Approve TIN Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tin-requests.approve', $request) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to approve this TIN request? A TIN number will be generated for the applicant.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-1"></i> Confirm Approval
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Reject TIN Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('tin-requests.reject', $request) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('rejection_reason') is-invalid @enderror" 
                                  id="rejection_reason" name="rejection_reason" 
                                  rows="3" required>{{ old('rejection_reason') }}</textarea>
                        @error('rejection_reason')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-1"></i> Confirm Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan

@endsection
