{{-- Attestation Result Partial (converted from after-qr-code-scan-view-file.html) --}}
<div class="main-container">
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 20px; border-radius: 6px; margin-bottom: 18px; font-size: 1.1em;">
            {{ session('success') }}
        </div>
    @endif
    <div class="vertical-text">Powered by VFS Global</div>
    <div class="logos-header">
        <div class="logo-left">
            <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/logo/oman_logo.png" alt="Oman Post Logo" class="logo-img">
        </div>
        <div class="logo-right">
            <div class="ministry-info">
                <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/images/khanjar.jpg" alt="Sultanate of Oman Emblem" class="logo-img">
            </div>
        </div>
    </div>
    <div class="document-container">        
        <div class="titles">
            <div class="arabic-title">بيانات التصديق الرقمي</div>
            <div class="english-title">Digital Attestation Result</div>
        </div>
        <div class="section">
            <table class="tableheading"><tr><td class="Heading tbtrtd">Transaction Details</td></tr></table>
            <table class="table">
                <tr><td class="tbtrtd tdwidthleft">Transaction Number</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->transaction_number }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Payment ID</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->payment_id }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Total Payment</td><td class="labelsvalue tbtrtd tdwidthright">OMR {{ $attestation->total_payment }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Transaction Date</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->transaction_date }}</td></tr>
            </table>
        </div>
        <div class="section">
            <table class="tableheading"><tr><td class="Heading tbtrtd">Candidate Details</td></tr></table>
            <table class="table">
                <tr><td class="tbtrtd tdwidthleft">Document Type</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->document_type }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Applicant Name</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->applicant_name }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Email Id</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->email }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Phone Number</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->phone }}</td></tr>
            </table>
        </div>
        <div class="section">
            <table class="tableheading"><tr><td class="Heading tbtrtd">Verification Details</td></tr></table>
            <table class="table">
                <tr><td class="tbtrtd tdwidthleft">Verifier Name</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->verifier_name }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Verification Status</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->verification_status }}</td></tr>
                <tr><td class="tbtrtd tdwidthleft">Verification Date & Time</td><td class="labelsvalue tbtrtd tdwidthright">
                    {{ \Carbon\Carbon::parse($attestation->verification_datetime)->format('Y-m-d H:i:s') }}
                </td></tr>
            </table>
        </div>
        <div class="section">
            <table class="tableheading"><tr><td class="Heading tbtrtd">Document Details</td></tr></table>
            <table class="table" style="border-collapse: collapse;">
                <tr>
                    <td class="tbtrtd tdwidthleft">Attested Document</td>
                    <td class="labelsvalue tbtrtd tdwidthright">
                        <a href="{{ route('attestations.pdf', $attestation->id) }}" class="view-document" target="_blank">View Attested Document</a>
                    </td>
                </tr>
                <tr style="border-top: 2px solid black;">
                    <td class="tbtrtd tdwidthleft">Attested Document</td>
                    <td class="labelsvalue tbtrtd tdwidthright">
                        <a href="{{ route('attestations.pdf', $attestation->id) }}" class="view-document" target="_blank">View Document</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="section" style="text-align: center; margin-top: 40px;">
            <a href="{{ route('attestations.create') }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);">
                📝 Create New Attestation
            </a>
        </div>
    </div>
</div>
{{-- Add modal and QR code logic as needed, using Laravel variables for dynamic data --}}
