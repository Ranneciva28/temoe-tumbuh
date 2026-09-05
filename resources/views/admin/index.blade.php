@extends('layouts.admin')
@section('title','Dashboard')
@section('topbar','Market Validation')
@section('content')
<div class="heading"><div><h1>Market Validation Dashboard</h1><p>Pantau apakah demand Cilegon–Serang sudah cukup kuat untuk membuka Temoe Tumbuh.</p></div><div class="actions"><a class="btn btn-outline" href="{{ route('admin.leads.export') }}">Export CSV</a><a class="btn btn-primary" href="{{ route('admin.leads.index') }}">Lihat Semua Leads</a></div></div>
<div class="grid grid-4">
    <div class="card metric"><div class="label">Total Leads</div><div class="value">{{ number_format($total) }}</div><div class="hint">Semua formulir masuk</div></div>
    <div class="card metric"><div class="label">Qualified</div><div class="value">{{ number_format($qualified) }}</div><div class="hint">Qualified + High Intent + Reserved</div></div>
    <div class="card metric"><div class="label">High Intent</div><div class="value">{{ number_format($highIntent) }}</div><div class="hint">High Intent + Reserved</div></div>
    <div class="card metric"><div class="label">Reserved</div><div class="value">{{ number_format($reserved) }}</div><div class="hint">Komitmen terkuat</div></div>
</div>
<div style="height:16px"></div>
<div class="grid grid-3">
    <div class="card card-pad"><h3 class="section-title">Lead Source</h3><div class="kpi-list">@forelse($bySource as $row)<div class="kpi-row"><span>{{ $row->label }}</span><strong>{{ $row->total }}</strong></div>@empty<div class="empty">Belum ada data.</div>@endforelse</div></div>
    <div class="card card-pad"><h3 class="section-title">Kota / Area</h3><div class="kpi-list">@forelse($byCity as $row)<div class="kpi-row"><span>{{ $row->label }}</span><strong>{{ $row->total }}</strong></div>@empty<div class="empty">Belum ada data.</div>@endforelse</div></div>
    <div class="card card-pad"><h3 class="section-title">Budget Range</h3><div class="kpi-list">@forelse($byBudget as $row)<div class="kpi-row"><span>{{ $row->label }}</span><strong>{{ $row->total }}</strong></div>@empty<div class="empty">Belum ada data.</div>@endforelse</div></div>
</div>
<div style="height:16px"></div>
<div class="grid grid-2">
    <div class="card card-pad"><h3 class="section-title">Reservation Readiness</h3><div class="metric" style="padding:4px 0"><div class="value">{{ number_format($reservationInterest) }}</div><div class="hint">orang menyatakan minat untuk reservasi / prioritas slot</div></div>@if($total > 0)<div style="margin-top:14px;height:10px;background:#eeece5;border-radius:99px;overflow:hidden"><div style="height:100%;width:{{ min(100, round(($reservationInterest/$total)*100)) }}%;background:#456b5c"></div></div><div class="help" style="margin-top:7px">{{ round(($reservationInterest/$total)*100,1) }}% dari seluruh leads</div>@endif</div>
    <div class="card"><div class="card-pad" style="padding-bottom:8px"><h3 class="section-title">Lead Terbaru</h3></div><div class="table-wrap"><table class="table"><thead><tr><th>Orang Tua</th><th>Area</th><th>Status</th></tr></thead><tbody>@forelse($recentLeads as $lead)<tr><td><a href="{{ route('admin.leads.show',$lead) }}"><strong>{{ $lead->parent_name }}</strong></a><div class="help">{{ $lead->created_at->format('d M, H:i') }}</div></td><td>{{ $lead->city ?: '—' }}</td><td><span class="badge badge-{{ $lead->status }}">{{ str_replace('_',' ',strtoupper($lead->status)) }}</span></td></tr>@empty<tr><td colspan="3" class="empty">Belum ada lead.</td></tr>@endforelse</tbody></table></div></div>
</div>
@endsection
