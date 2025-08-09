{{-- Attestation Form Partial (converted from form.html) --}}
<div style="display: flex; flex-direction: row; max-width: 1100px; margin: 40px auto;">
    <div class="vertical-text" style="writing-mode: vertical-rl; transform: rotate(180deg); color: #49afcd; font-weight: 500; font-size: 18px; opacity: 0.8; margin-right: 24px; display: flex; align-items: center; min-width: 32px;">Powered by VFS Global</div>
    <div class="main-container" style="flex: 1; background: #fff; border-radius: 18px; box-shadow: 0 8px 32px rgba(0,0,0,0.10); padding: 0 0 32px 0; position: relative;">
    <div class="document-container" style="background: #fff; border-radius: 18px 18px 0 0; padding: 0 0 0 0;">
        <div class="logos-header" style="display: flex; justify-content: space-between; align-items: center; padding: 32px 40px 0 40px;">
            <div class="logo-left">
                <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/logo/oman_logo.png" alt="Oman Post Logo" class="logo-img" style="height: 48px;">
            </div>
            <div class="logo-right">
                <div class="ministry-info" style="display: flex; flex-direction: column; align-items: center;">
                    <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/images/khanjar.jpg" alt="Sultanate of Oman Emblem" class="logo-img" style="height: 48px;">
                    <span class="ministry-text" style="color: #d32f2f; font-size: 16px; font-weight: bold; margin-top: 5px;">Foreign Ministry</span>
                </div>
            </div>
        </div>
        <div class="titles" style="text-align: center; margin: 32px 0 24px 0;">
            <div class="arabic-title" style="font-size: 28px; color: #667eea; margin-bottom: 6px; direction: rtl; font-weight: bold;">نموذج التصديق الرقمي</div>
            <div class="english-title" style="font-size: 28px; color: #667eea; font-weight: bold;">Digital Attestation Form</div>
        </div>
        <form class="attestation-form" 
            action="{{ isset($editMode) && $editMode ? route('attestations.update', $attestation->id) : route('attestations.store') }}" 
            method="POST" enctype="multipart/form-data" style="padding: 0 40px;">
            @csrf
            @if(isset($editMode) && $editMode)
                @method('PUT')
            @endif
            <div class="section" style="background: #f8fafc; border-radius: 10px; padding: 24px 24px 16px 24px; margin-bottom: 32px;">
                <div class="section-header" style="font-size: 20px; font-weight: bold; color: #2d3748; margin-bottom: 18px;">Transaction Details</div>
                <div class="form-group">
                    <label for="transaction_number">Transaction Number:</label>
                    <input type="text" id="transaction_number" name="transaction_number" value="{{ old('transaction_number', $attestation->transaction_number ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="payment_id">Payment ID:</label>
                    <input type="text" id="payment_id" name="payment_id" value="{{ old('payment_id', $attestation->payment_id ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="total_payment">Total Payment (OMR):</label>
                    <input type="number" id="total_payment" name="total_payment" step="0.01" value="{{ old('total_payment', $attestation->total_payment ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="transaction_date">Transaction Date:</label>
                    <input type="date" id="transaction_date" name="transaction_date" value="{{ old('transaction_date', $attestation->transaction_date ?? '') }}" required>
                </div>
            </div>
            <div class="section" style="background: #f8fafc; border-radius: 10px; padding: 24px 24px 16px 24px; margin-bottom: 32px;">
                <div class="section-header" style="font-size: 20px; font-weight: bold; color: #2d3748; margin-bottom: 18px;">Candidate Details</div>
                <div class="form-group">
                    <label for="document_type">Document Type:</label>
                    <select id="document_type" name="document_type" required>
                        <option value="">Select document type</option>
                        @php $docType = old('document_type', $attestation->document_type ?? '') @endphp
                        <option value="Other commercial Documents" {{ $docType == 'Other commercial Documents' ? 'selected' : '' }}>Other commercial Documents</option>
                        <option value="Educational Documents" {{ $docType == 'Educational Documents' ? 'selected' : '' }}>Educational Documents</option>
                        <option value="Personal Documents" {{ $docType == 'Personal Documents' ? 'selected' : '' }}>Personal Documents</option>
                        <option value="Business Documents" {{ $docType == 'Business Documents' ? 'selected' : '' }}>Business Documents</option>
                        <option value="Legal Documents" {{ $docType == 'Legal Documents' ? 'selected' : '' }}>Legal Documents</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="applicant_name">Applicant Name:</label>
                    <input type="text" id="applicant_name" name="applicant_name" value="{{ old('applicant_name', $attestation->applicant_name ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email ID:</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $attestation->email ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $attestation->phone ?? '') }}" required>
                </div>
            </div>
            <div class="section" style="background: #f8fafc; border-radius: 10px; padding: 24px 24px 16px 24px; margin-bottom: 32px;">
                <div class="section-header" style="font-size: 20px; font-weight: bold; color: #2d3748; margin-bottom: 18px;">Verification Details</div>
                <div class="form-group">
                    <label for="verifier_name">Verifier Name:</label>
                    <input type="text" id="verifier_name" name="verifier_name" value="{{ old('verifier_name', $attestation->verifier_name ?? 'Foreign Ministry - Oman') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="verification_status">Verification Status:</label>
                    <select id="verification_status" name="verification_status" required>
                        <option value="">Select status</option>
                        @php $status = old('verification_status', $attestation->verification_status ?? '') @endphp
                        <option value="Pending" {{ $status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Approved" {{ $status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="Under Review" {{ $status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="verificationDate">Verification Date & Time:</label>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <input type="date" id="verificationDate" name="verificationDate" required style="flex: 1;" value="{{ old('verificationDate', isset($attestation) ? (isset($attestation->verification_datetime) ? explode(' ', $attestation->verification_datetime)[0] : '') : '') }}">
                        <input type="time" id="verificationTime" name="verificationTime" step="1" required style="flex: 1;" value="{{ old('verificationTime', isset($attestation) ? (isset($attestation->verification_datetime) ? (count(explode(' ', $attestation->verification_datetime)) > 1 ? explode(':', explode(' ', $attestation->verification_datetime)[1])[0] . ':' . explode(':', explode(' ', $attestation->verification_datetime)[1])[1] . ':' . explode(':', explode(' ', $attestation->verification_datetime)[1])[2] : '') : '') : '') }}">
                    </div>
                    <small>Format: YYYY-MM-DD HH:MM:SS</small>
                </div>
            </div>
            <div class="section" style="background: #f8fafc; border-radius: 10px; padding: 24px 24px 16px 24px; margin-bottom: 32px;">
                <div class="section-header" style="font-size: 20px; font-weight: bold; color: #2d3748; margin-bottom: 18px;">Document Details</div>
                <div id="document-upload-repeater">
                    @php
                        $existingFiles = [];
                        if(isset($attestation) && $attestation->original_document_path) {
                            $existingFiles = @json_decode($attestation->original_document_path, true);
                            if(!$existingFiles) $existingFiles = [$attestation->original_document_path];
                        }
                    @endphp
                    @if(isset($editMode) && $editMode && count($existingFiles))
                        @foreach($existingFiles as $i => $file)
                        <div class="form-group document-upload-group">
                            <label>Existing Document {{ $i+1 }}:</label>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">View File</a>
                        </div>
                        @endforeach
                    @endif
                    <div class="form-group document-upload-group">
                        <label for="originalDocument0">Original Document:</label>
                        <input type="file" id="originalDocument0" name="original_document[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" @if(!(isset($editMode) && $editMode)) required @endif>
                        <button type="button" class="btn-remove-upload" style="display:none; background-color:#e74c3c; color:#fff; padding:6px 14px;">Remove</button>
                        <small>Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG</small>
                    </div>
                </div>
                <button type="button" id="add-upload-btn" class="btn-add-upload">Add Another Document</button>
            </div>
            <div class="form-actions" style="margin-top: 32px; text-align: right;">
                <button type="submit" class="btn-submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; border: none; border-radius: 6px; padding: 10px 24px; font-size: 16px; font-weight: 600; cursor: pointer; margin-right: 10px;">
                    {{ isset($editMode) && $editMode ? 'Update Attestation' : 'Submit Attestation' }}
                </button>
                <button type="reset" class="btn-reset" style="background: #e2e8f0; color: #4a5568; border: none; border-radius: 6px; padding: 10px 24px; font-size: 16px; font-weight: 600; cursor: pointer; margin-right: 10px;">Reset Form</button>
            </div>
        </form>
    </div>
</div>
<script>
// ...JS logic for file repeater and date/time auto-fill (as in your HTML)...
</script>
