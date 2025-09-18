@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h4>Apply for TIN</h4>
                    <p class="mb-0">Please fill in all the required information to apply for a Tax Identification Number (TIN)</p>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tin-requests.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 class="mb-3 border-bottom pb-2">Personal Information</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="full_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" 
                                       value="{{ old('full_name', $user->name) }}" required>
                                @error('full_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" 
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" 
                                       value="{{ old('phone', $user->phone ?? '') }}" required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="nid_number" class="form-label">National ID (NID) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nid_number') is-invalid @enderror" 
                                       id="nid_number" name="nid_number" 
                                       value="{{ old('nid_number') }}" required>
                                @error('nid_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" 
                                       value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="father_name" class="form-label">Father's Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                                       id="father_name" name="father_name" 
                                       value="{{ old('father_name') }}" required>
                                @error('father_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="mother_name" class="form-label">Mother's Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror" 
                                       id="mother_name" name="mother_name" 
                                       value="{{ old('mother_name') }}" required>
                                @error('mother_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="spouse_name" class="form-label">Spouse's Name (if any)</label>
                                <input type="text" class="form-control @error('spouse_name') is-invalid @enderror" 
                                       id="spouse_name" name="spouse_name" 
                                       value="{{ old('spouse_name') }}">
                                @error('spouse_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 class="mb-3 border-bottom pb-2">Address Information</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="present_address" class="form-label">Present Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('present_address') is-invalid @enderror" 
                                          id="present_address" name="present_address" 
                                          rows="3" required>{{ old('present_address') }}</textarea>
                                @error('present_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="permanent_address" class="form-label">Permanent Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('permanent_address') is-invalid @enderror" 
                                          id="permanent_address" name="permanent_address" 
                                          rows="3" required>{{ old('permanent_address') }}</textarea>
                                @error('permanent_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="same_as_present" 
                                           onchange="copyPresentAddress()">
                                    <label class="form-check-label" for="same_as_present">
                                        Same as Present Address
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h5 class="mb-3 border-bottom pb-2">Employment Information</h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="occupation" class="form-label">Occupation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('occupation') is-invalid @enderror" 
                                       id="occupation" name="occupation" 
                                       value="{{ old('occupation') }}" required>
                                @error('occupation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="company_name" class="form-label">Company/Business Name</label>
                                <input type="text" class="form-control @error('company_name') is-invalid @enderror" 
                                       id="company_name" name="company_name" 
                                       value="{{ old('company_name') }}">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label for="company_address" class="form-label">Company/Business Address</label>
                                <textarea class="form-control @error('company_address') is-invalid @enderror" 
                                          id="company_address" name="company_address" 
                                          rows="2">{{ old('company_address') }}</textarea>
                                @error('company_address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="mb-3 border-bottom pb-2">Additional Information</h5>
                                <div class="mb-3">
                                    <label for="purpose" class="form-label">Purpose of Applying for TIN <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('purpose') is-invalid @enderror" 
                                              id="purpose" name="purpose" 
                                              rows="3" required>{{ old('purpose') }}</textarea>
                                    @error('purpose')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input @error('declaration') is-invalid @enderror" 
                                           type="checkbox" id="declaration" name="declaration" required>
                                    <label class="form-check-label" for="declaration">
                                        I hereby declare that the information provided is true and correct to the best of my knowledge.
                                    </label>
                                    @error('declaration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyPresentAddress() {
        const presentAddress = document.getElementById('present_address').value;
        if (document.getElementById('same_as_present').checked) {
            document.getElementById('permanent_address').value = presentAddress;
        }
    }
    
    // Initialize date picker with max date as today
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date_of_birth').max = today;
    });
</script>
@endpush
@endsection
