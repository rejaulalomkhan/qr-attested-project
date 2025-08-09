<table style="width:420px;min-height:120px;border:1px solid #b49650;background:#fff;padding:8px 0 8px 0;font-family:'DejaVu Sans', Arial, 'Noto Sans', 'Segoe UI', sans-serif;font-size:13px;line-height:1.7;box-sizing:border-box;">
    <tr>
        <td style="width:32%;text-align:left;font-weight:bold;vertical-align:top;">
            e-Verify No<br>
            Verify By<br>
            Verify at<br>
            Applicant Name<br>
            Document Name<br>
            Date of Attestation<br>
            Approver Name
        </td>
        <td style="width:36%;text-align:center;vertical-align:top;word-break:break-all;">
            {{ $info['verify_no'] ?? '-' }}<br>
            {{ $info['verifier'] ?? '-' }}<br>
            {{ $info['verify_at'] ?? '-' }}<br>
            {{ $info['name'] ?? '-' }}<br>
            {{ $info['document'] ?? '-' }}<br>
            {{ $info['date'] ?? '-' }}<br>
            {{ $info['approver'] ?? '-' }}
        </td>
        <td style="width:32%;text-align:right;font-weight:bold;vertical-align:top;direction:rtl;font-family:'DejaVu Sans', Arial, 'Noto Sans', 'Segoe UI', sans-serif;">
            رقم التصديق<br>
            تم التحقق من قبل<br>
            تم التحقق في<br>
            اسم العميل<br>
            اسم الوثيقة<br>
            تاريخ التصديق<br>
            تمت المصادقة من قبل
        </td>
    </tr>
</table>
