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
    font-family: Tahoma, 'Segoe UI', Arial, 'Noto Sans', 'Noto Naskh Arabic', 'DejaVu Sans', sans-serif;
    font-size: 15px;
    line-height: 1.12;
    letter-spacing: 0;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    margin: 5px 45px 0px 2px;">
    @foreach ($rows as $row)
        <tr>
            <td style="width:22%;text-align:left;font-weight:600;vertical-align:top;white-space:normal;">{{ $row['label'] }}</td>
            <td style="width:50%;text-align:left;vertical-align:top;word-break:break-word;white-space:normal;font-weight:700;">{{ $info[$row['key']] ?? '-' }}</td>
            <td style="width:28%;text-align:left;font-weight:600;vertical-align:top;direction:rtl;padding-left:10px;white-space:normal;">{{ $row['label_ar'] }}</td>
        </tr>
    @endforeach
</table>
