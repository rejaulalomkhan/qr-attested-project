<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Attestation Result</title>
    <link rel="stylesheet" href="{{ asset('assets/result-view.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <style>
        .doc-modal { position: fixed; inset: 0; z-index: 9999; display: none; }
        .doc-modal.doc-modal--open { display: block; }
        .doc-modal__backdrop { position: absolute; inset: 0; background: rgba(0, 0, 0, 0.6); }
        .doc-modal__content { position: absolute; inset: 0; display: flex; flex-direction: column; background: #eef0f2; }
        .doc-modal__close { position: fixed; top: 12px; right: 12px; background: rgba(0,0,0,0.7); color: #fff; border: none; font-size: 14px; padding: 8px 12px; border-radius: 16px; cursor: pointer; z-index: 3; }
        .doc-modal__body { position: relative; flex: 1; overflow: hidden; background: transparent; display: flex; justify-content: center; align-items: center; padding: 0; }
        .doc-modal__content-inner { min-height: 100%; display: none; }
        .doc-modal__loader { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; font: 600 16px/1 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Arial; color: #333; background: #fff; }
        .doc-modal__error { position: absolute; inset: 0; display: none; align-items: center; justify-content: center; background: #fff; color: #b00020; padding: 24px; text-align: center; }
        .doc-modal__error a { color: #2962ff; text-decoration: underline; }
        .doc-modal__page { width: 1347px; max-width: 100vw; height: 100vh; overflow: auto; background: #ffffff; border-radius: 0; box-shadow: none; padding: 0; }
        @media (max-width: 820px) {
            .doc-modal__page { height: 100vh; border-radius: 0; max-width: 100vw; }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="vertical-text">Powered by VFS Global</div>
        <div class="document-container">
            <div class="logos-header">
                <div class="logo-left">
                    <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/logo/oman_logo.png" alt="Oman Post Logo" class="logo-img">
                </div>
                <div class="logo-right">
                    <div class="ministry-info">
                        <img src="https://omanpostapi.docswallet.com/pdf/document_repository/images/images/khanjar.jpg" alt="Sultanate of Oman Emblem" class="logo-img">
                        <span class="ministry-text">Foreign Ministry</span>
                    </div>
                </div>
            </div>
            <div class="titles">
                <div class="arabic-title">بيانات التصديق الرقمي</div>
                <div class="english-title">Digital Attestation Result</div>
            </div>
            <div class="section">
                <table class="tableheading">
                    <tr><td class="Heading tbtrtd">Transaction Details</td></tr>
                </table>
                <table class="table">
                    <tr><td class="tbtrtd tdwidthleft">Transaction Number</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->transaction_number }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Payment ID</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->payment_id }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Total Payment</td><td class="labelsvalue tbtrtd tdwidthright">OMR {{ $attestation->total_payment }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Transaction Date</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->transaction_date }}</td></tr>
                </table>
            </div>
            <div class="section">
                <table class="tableheading">
                    <tr><td class="Heading tbtrtd">Candidate Details</td></tr>
                </table>
                <table class="table">
                    <tr><td class="tbtrtd tdwidthleft">Document Type</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->document_type }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Applicant Name</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->applicant_name }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Email Id</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->email }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Phone Number</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->phone }}</td></tr>
                </table>
            </div>
            <div class="section">
                <table class="tableheading">
                    <tr><td class="Heading tbtrtd">Verification Details</td></tr>
                </table>
                <table class="table">
                    <tr><td class="tbtrtd tdwidthleft">Verifier Name</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->verifier_name }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Verification Status</td><td class="labelsvalue tbtrtd tdwidthright">{{ $attestation->verification_status }}</td></tr>
                    <tr><td class="tbtrtd tdwidthleft">Verification Date & Time</td><td class="labelsvalue tbtrtd tdwidthright">{{ \Carbon\Carbon::parse($attestation->verification_datetime)->format('Y-m-d H:i:s') }}</td></tr>
                </table>
            </div>
            <div class="section">
                <table class="tableheading">
                    <tr><td class="Heading tbtrtd">Document Details</td></tr>
                </table>
                <table class="table" style="border-collapse: collapse;">
                    <tr>
                        <td class="tbtrtd tdwidthleft">Original Document</td>
                        <td class="labelsvalue tbtrtd tdwidthright">
                            <a href="#" class="view-document" data-doc="original" data-id="{{ $attestation->id }}">View Document</a>
                        </td>
                    </tr>
                    <tr style="border-top: 2px solid black;">
                        <td class="tbtrtd tdwidthleft">Attested Document</td>
                        <td class="labelsvalue tbtrtd tdwidthright">
                            <a href="#" class="view-document" data-doc="attested" data-id="{{ $attestation->id }}">View Document</a>
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
    <div id="documentModal" class="doc-modal" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="doc-modal__backdrop" data-doc-modal-close></div>
        <div class="doc-modal__content">
            <button type="button" class="doc-modal__close" title="Close" aria-label="Close" data-doc-modal-close>&times;</button>
            <div class="doc-modal__body">
                <div class="doc-modal__loader" id="docLoader">Loading…</div>
                <div class="doc-modal__error" id="docError"></div>
                <div class="doc-modal__page"><div id="docContent" class="doc-modal__content-inner"></div></div>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const modal = document.getElementById('documentModal');
            const content = document.getElementById('docContent');
            const loader = document.getElementById('docLoader');
            const errorBox = document.getElementById('docError');
            let previousHtmlOverflow = '';
            let previousBodyOverflow = '';

            function openModalWithApi(id, type) {
                if (!id || !type) return;
                // Prepare UI
                errorBox.style.display = 'none';
                errorBox.textContent = '';
                loader.style.display = 'flex';
                content.style.display = 'none';
                content.innerHTML = '';
                // Open modal
                modal.classList.add('doc-modal--open');
                modal.setAttribute('aria-hidden', 'false');
                previousHtmlOverflow = document.documentElement.style.overflow;
                previousBodyOverflow = document.body.style.overflow;
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';

                const url = `/attestations/${encodeURIComponent(id)}/content/${encodeURIComponent(type)}`;
                fetch(url, { credentials: 'same-origin', headers: { 'Accept': 'application/json' } })
                  .then(function(response) {
                      if (!response.ok) throw new Error('HTTP ' + response.status + ' ' + response.statusText);
                      return response.json();
                  })
                  .then(function(data) {
                      if (!data || typeof data.html !== 'string') throw new Error('Malformed response');
                      content.innerHTML = data.html;
                      loader.style.display = 'none';
                      content.style.display = 'block';
                  })
                  .catch(function(err) {
                      loader.style.display = 'none';
                      errorBox.innerHTML = 'Unable to load content. <br><small>(' + err.message + ')</small>';
                      errorBox.style.display = 'flex';
                  });
            }

            function closeModal() {
                modal.classList.remove('doc-modal--open');
                modal.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = previousHtmlOverflow;
                document.body.style.overflow = previousBodyOverflow;
                // Reset content
                content.innerHTML = '';
                content.style.display = 'none';
                loader.style.display = 'none';
                errorBox.style.display = 'none';
            }

            // Bind close interactions
            modal.addEventListener('click', function(e) {
                if (e.target && e.target.hasAttribute('data-doc-modal-close')) {
                    closeModal();
                }
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('doc-modal--open')) {
                    closeModal();
                }
            });

            // Intercept clicks on document links
            const links = document.querySelectorAll('a.view-document');
            links.forEach(function(link) {
                link.addEventListener('click', function(ev) {
                    ev.preventDefault();
                    const id = link.getAttribute('data-id');
                    const type = link.getAttribute('data-doc');
                    openModalWithApi(id, type);
                });
            });
        })();
    </script>
</body>
</html>
