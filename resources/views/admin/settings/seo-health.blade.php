@extends('layouts.admin')

@section('title', 'SEO Health Checker')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">SEO Health Checker</h3>
  <span class="badge bg-{{ $score >= 85 ? 'success' : ($score >= 60 ? 'warning text-dark' : 'danger') }} fs-6">Score: {{ $score }}/100</span>
</div>

<div class="card mb-3">
  <div class="card-body">
    <h5 class="mb-3">Summary</h5>
    <ul class="mb-0">
      <li>Total checks: {{ count($checks) }}</li>
      <li>Passed: {{ collect($checks)->where('status', 'pass')->count() }}</li>
      <li>Warnings: {{ collect($checks)->where('status', 'warn')->count() }}</li>
      <li>Failed: {{ collect($checks)->where('status', 'fail')->count() }}</li>
    </ul>
  </div>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table mb-0">
      <thead>
        <tr>
          <th>Check</th>
          <th>Status</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        @foreach($checks as $check)
        <tr>
          <td>{{ $check['label'] }}</td>
          <td>
            @if($check['status'] === 'pass')
            <span class="badge bg-success">Pass</span>
            @elseif($check['status'] === 'warn')
            <span class="badge bg-warning text-dark">Warning</span>
            @else
            <span class="badge bg-danger">Fail</span>
            @endif
          </td>
          <td>{{ $check['message'] }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="card border-0 shadow-sm mt-4">
  <div class="card-header bg-white border-0 pb-0">
    <h5 class="mb-0">Detailed SEO Parameters</h5>
    <small class="text-muted">Technical parameters detected from homepage and SEO endpoints.</small>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-striped align-middle mb-0">
        <thead>
          <tr>
            <th style="width: 24%;">Parameter</th>
            <th style="width: 41%;">Value</th>
            <th style="width: 12%;">Status</th>
            <th style="width: 23%;">Notes</th>
          </tr>
        </thead>
        <tbody>
          @foreach($parameters as $parameter)
          @php
          $badge = match($parameter['status']) {
          'pass' => 'success',
          'warn' => 'warning text-dark',
          default => 'danger'
          };
          @endphp
          <tr>
            <td class="fw-semibold">{{ $parameter['label'] }}</td>
            <td class="text-break">{{ $parameter['value'] }}</td>
            <td>
              <span class="badge bg-{{ $badge }}">{{ strtoupper($parameter['status']) }}</span>
            </td>
            <td class="text-muted">{{ $parameter['note'] }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection