@php
    $rows = [
        ['label' => 'e-Verify No',       'key' => 'verify_no', 'label_ar' => 'رقم التصديق'],
        ['label' => 'Verify By',         'key' => 'verifier',  'label_ar' => 'تم التحقق من قبل'],
        ['label' => 'Verify at',         'key' => 'verify_at', 'label_ar' => 'تم التحقق في'],
        ['label' => 'Applicant Name',    'key' => 'name',      'label_ar' => 'اسم العميل'],
        ['label' => 'Document Name',     'key' => 'document',  'label_ar' => 'اسم الوثيقة'],
        ['label' => 'Date of Attestation','key' => 'date',     'label_ar' => 'تاريخ التصديق'],
        ['label' => 'Approver Name',     'key' => 'approver',  'label_ar' => 'تمت المصادقة من قبل'],
    ];
@endphp

<table style="width: 488px;
    padding: 4px 13px 5px 3px;
    font-family: 'DejaVu Sans', Arial, 'Noto Sans', 'Segoe UI', sans-serif;
    font-size: 15px;
    line-height: 1.2;
    margin: 5px 28px 0 2px;">
    @foreach ($rows as $row)
        <tr>
            <td style="width:23%;text-align:left;font-weight:bold;vertical-align:top;">{{ $row['label'] }}</td>
            <td style="width:50%;text-align:left;vertical-align:top;word-break:break-all;">{{ $info[$row['key']] ?? '-' }}</td>
            <td style="width:27%;text-align:left;font-weight:bold;vertical-align:top;direction:rtl;padding-left:10px;">{{ $row['label_ar'] }}</td>
        </tr>
    @endforeach
</table>
