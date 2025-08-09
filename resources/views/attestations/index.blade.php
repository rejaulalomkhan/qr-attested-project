@extends('layouts.app')

@section('content')
<div class="main-container">
    <div style="display: flex; justify-content: center;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; max-width: 1100px; width: 100%; margin-top: 32px;">
            <h2 style="margin: 0;">All Attestations</h2>
            <a href="{{ route('attestations.create') }}" class="btn-new-attestation">+ New Attestation</a>
        </div>
    </div>
    <div style="display: flex; justify-content: center;">
        <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); padding: 32px 24px; max-width: 1100px; width: 100%;">
            <div style="overflow-x:auto;">
                <table id="attestations-table" class="display styled-table" style="min-width:900px; margin:0 auto;">
</style>
<style>
/* DataTables controls spacing */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    margin-bottom: 18px !important;
}
.dataTables_wrapper .dataTables_length {
    float: left;
}
.dataTables_wrapper .dataTables_filter {
    float: right;
}
.dataTables_wrapper .dataTables_info {
    margin-top: 18px;
}
.dataTables_wrapper .dataTables_paginate {
    margin-top: 18px;
}
</style>
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
                            <td>{{ $att->transaction_number }}</td>
                            <td>{{ $att->applicant_name }}</td>
                            <td>{{ $att->document_type }}</td>
                            <td>{{ $att->verification_status }}</td>
                            <td>{{ \Carbon\Carbon::parse($att->verification_datetime)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <a href="{{ route('attestations.show', $att->id) }}" target="_blank">View</a>
                                <a href="{{ route('attestations.pdf', $att->id) }}" target="_blank">PDF</a>
                                <!-- Temporary Download Icon -->
                                <a href="{{ route('attestations.pdf', $att->id) }}" title="Download Attested PDF" style="margin:0 4px;vertical-align:middle;" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:inline;vertical-align:middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4"/></svg>
                                </a>
                                <a href="{{ route('attestations.edit', $att->id) }}" style="color:#e67e22;" title="Edit">Edit</a>
                                <a href="#" style="color:#e74c3c;" title="Delete (not implemented)" onclick="return confirm('Are you sure you want to delete this attestation?')">Delete</a>
                            </td>
</style>
<style>
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
.btn-new-attestation:hover {
    background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}
</style>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
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
