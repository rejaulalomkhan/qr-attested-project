<!-- Blade template for creating an attestation, based on your form.html design. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Attestation Form</title>
    <link rel="stylesheet" href="{{ asset('assets/attestation-form.css') }}">
    <style>
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            color: #374151;
            font-weight: 600;
        }
        .back-link:hover { color: #111827; }
    </style>
</head>
<body>
    <div style="display:flex; justify-content:center; margin-top: 16px;">
        <div style="max-width:1100px; width:100%; padding: 0 12px;">
            <a href="{{ route('attestations.index') }}" class="back-link" aria-label="Back to all attestations">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span>Back to list</span>
            </a>
        </div>
    </div>
    @include('attestations.partials.form')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set current date and time for verification
        const now = new Date();
        const dateString = now.toISOString().slice(0, 10);
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        document.getElementById('verificationDate').value = dateString;
        document.getElementById('verificationTime').value = timeString;
        const transactionDate = document.getElementById('transaction_date') || document.getElementById('transactionDate');
        if (transactionDate) transactionDate.value = dateString;

        // Repeater logic for multiple file uploads
        const repeater = document.getElementById('document-upload-repeater');
        const addBtn = document.getElementById('add-upload-btn');

        addBtn.addEventListener('click', function() {
            const groups = repeater.querySelectorAll('.document-upload-group');
            const idx = groups.length;
            const newGroup = groups[0].cloneNode(true);

            // Update input id and clear value
            const input = newGroup.querySelector('input[type="file"]');
            input.id = 'originalDocument' + idx;
            input.value = '';
            input.required = false; // Only first is required

            // Show remove button
            const removeBtn = newGroup.querySelector('.btn-remove-upload');
            removeBtn.style.display = 'inline-block';

            // Remove previous event listeners by replacing the node
            const newRemoveBtn = removeBtn.cloneNode(true);
            removeBtn.parentNode.replaceChild(newRemoveBtn, removeBtn);

            newRemoveBtn.addEventListener('click', function() {
                newGroup.remove();
            });

            repeater.appendChild(newGroup);
        });

        // Remove button for first group (hidden)
        const firstRemoveBtn = repeater.querySelector('.btn-remove-upload');
        if (firstRemoveBtn) firstRemoveBtn.style.display = 'none';
    });
    </script>
</body>
</html>
