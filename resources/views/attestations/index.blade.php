@extends('layouts.app')

@section('content')
<div class="main-container">
    <div style="display: flex; justify-content: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; max-width: 1100px; width: 100%; margin-top: 32px;">
            <h2 style="margin: 0;">All Attestations</h2>
            <a href="{{ route('attestations.create') }}" class="btn-new-attestation">+ New Attestation</a>
        </div>
    </div>
    @if (session('success'))
    <div style="display:flex; justify-content:center;">
        <div class="alert-success" role="alert" style="max-width:1100px; width:100%;">
            <div style="display:flex; align-items:center; gap:10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" aria-label="Dismiss" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    </div>
    @endif
    <div style="display: flex; justify-content: center;">
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 32px 24px; max-width: 1100px; width: 100%;">
            <div style="overflow-x:auto;">
                <table id="attestations-table" class="display styled-table" style="min-width:900px; margin:0 auto;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction #</th>
                            <th>Applicant</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($attestations as $att)
                        <tr>
                            <td>{{ $att->id }}</td>
                            <td> <a href="{{ route('attestations.show', $att->id) }}" target="_blank"> {{ $att->transaction_number }}</a></td>
                            <td>{{ $att->applicant_name }}</td>
                            <td style="font-size: 11px;">{{ $att->document_type }}</td>
                            <td>
                                @php
                                    $statusValue = trim($att->verification_status ?? '');
                                    $statusKey = strtolower(str_replace(' ', '-', $statusValue));
                                    $allowedStatuses = ['pending','approved','rejected','under-review'];
                                    $badgeKey = in_array($statusKey, $allowedStatuses) ? $statusKey : 'pending';
                                @endphp
                                <span class="badge badge-{{ $badgeKey }}">{{ $statusValue }}</span>
                            </td>
                            <td style="font-size: 11px;">{{ optional($att->created_at)->format('Y-m-d') }}</td>
                            <td style="display: flex; align-items: center; justify-content: center;">
                                <a href="{{ route('attestations.show', $att->id) }}" target="_blank" title="View" aria-label="View" style="margin:0 4px;vertical-align:middle;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:inline;vertical-align:middle;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                                
                                <a href="{{ route('attestations.edit', $att->id) }}" title="Edit" aria-label="Edit" style="margin:0 4px;vertical-align:middle;color:#e67e22;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M16.5 3.75a2.121 2.121 0 113 3L7.5 18.75 3 19.5l.75-4.5L16.5 3.75z"/></svg>
                                </a>
                                <form action="{{ route('attestations.destroy', $att->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this attestation?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" aria-label="Delete" style="background:none;border:none;margin:0 4px;vertical-align:middle;color:#e74c3c;cursor:pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862A2 2 0 015.867 19.142L5 7m5 4v6m4-6v6M9 7h6m-7 0V5a2 2 0 012-2h2a2 2 0 012 2v2"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* DataTables controls spacing */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 18px !important;
}
.dataTables_wrapper .dataTables_length { float: left; }
.dataTables_wrapper .dataTables_filter { float: right; }
.dataTables_wrapper .dataTables_info { margin-top: 18px; }
.dataTables_wrapper .dataTables_paginate { margin-top: 18px; }

/* Status badge styles */
.badge { display:inline-block; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 700; letter-spacing: 0.2px; }
.badge-pending { background: #FEF3C7; color: #92400E; }
.badge-approved { background: #D1FAE5; color: #065F46; }
.badge-rejected { background: #FEE2E2; color: #991B1B; }
.badge-under-review { background: #DBEAFE; color: #1E40AF; }

.btn-new-attestation {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 24px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    transition: background 0.2s;
}
.btn-new-attestation:hover { background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); }

.styled-table {
    border-collapse: collapse;
    font-size: 15px;
    min-width: 900px;
    width: 100%;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.styled-table thead tr {
    background-color: #667eea;
    color: #fff;
    text-align: left;
    font-weight: bold;
}
.styled-table th, .styled-table td {
    padding: 12px 16px;
    border: 1px solid #e0e6ed;
}
.styled-table tbody tr {
    border-bottom: 1px solid #e0e6ed;
}
.styled-table tbody tr:nth-of-type(even) {
    background-color: #f8fafc;
}
.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #667eea;
}
.styled-table tbody tr:hover {
    background-color: #e6eaff;
}
.styled-table a {
    color: #667eea;
    text-decoration: underline;
    font-weight: 500;
    margin-right: 8px;
}
.styled-table a:hover {
    color: #764ba2;
}

.alert-success {
    position: relative;
    margin: 0 0 16px 0;
    padding: 12px 40px 12px 14px;
    border-radius: 8px;
    background: #ECFDF5;
    color: #065F46;
    border: 1px solid #A7F3D0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}
.alert-close {
    position: absolute;
    right: 10px;
    top: 8px;
    background: none;
    border: none;
    font-size: 20px;
    color: #047857;
    cursor: pointer;
}
</style>
<!-- DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#attestations-table').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        order: [[0, 'desc']],
        language: {
            search: 'Search:',
            lengthMenu: 'Show _MENU_ entries',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            paginate: { previous: 'Prev', next: 'Next' }
        }
    });
});
</script>
@endsection
