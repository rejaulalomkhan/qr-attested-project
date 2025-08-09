
<!-- Blade template for editing an attestation, matching create page design -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attestation</title>
    <link rel="stylesheet" href="{{ asset('assets/attestation-form.css') }}">
</head>
<body>
    @include('attestations.partials.form', ['attestation' => $attestation, 'editMode' => true])
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Set current date and time for verification if not present
        const dateInput = document.getElementById('verificationDate');
        const timeInput = document.getElementById('verificationTime');
        if (dateInput && !dateInput.value) {
            const now = new Date();
            const dateString = now.toISOString().slice(0, 10);
            dateInput.value = dateString;
        }
        if (timeInput && !timeInput.value) {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            timeInput.value = `${hours}:${minutes}:${seconds}`;
        }

        // Repeater logic for multiple file uploads
        const repeater = document.getElementById('document-upload-repeater');
        const addBtn = document.getElementById('add-upload-btn');
        if (addBtn) {
            addBtn.addEventListener('click', function() {
                const groups = repeater.querySelectorAll('.document-upload-group');
                const idx = groups.length;
                const newGroup = groups[0].cloneNode(true);
                const input = newGroup.querySelector('input[type="file"]');
                input.id = 'originalDocument' + idx;
                input.value = '';
                input.required = false;
                const removeBtn = newGroup.querySelector('.btn-remove-upload');
                removeBtn.style.display = 'inline-block';
                const newRemoveBtn = removeBtn.cloneNode(true);
                removeBtn.parentNode.replaceChild(newRemoveBtn, removeBtn);
                newRemoveBtn.addEventListener('click', function() {
                    newGroup.remove();
                });
                repeater.appendChild(newGroup);
            });
            // Hide remove button for first group
            const firstRemoveBtn = repeater.querySelector('.btn-remove-upload');
            if (firstRemoveBtn) firstRemoveBtn.style.display = 'none';
        }
    });
    </script>
</body>
</html>
