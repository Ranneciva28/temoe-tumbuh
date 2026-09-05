<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Form Minat — Temoe Tumbuh</title>
<style>body{font-family:Arial,sans-serif;background:#fffaf5;color:#26332f;margin:0}.wrap{max-width:760px;margin:auto;padding:32px}.card{background:white;border:1px solid #eee2d6;border-radius:20px;padding:28px}.grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}.field{display:flex;flex-direction:column;gap:7px;margin-bottom:16px}label{font-weight:700}input,select,textarea{padding:12px;border:1px solid #d8d1c8;border-radius:10px;font:inherit}button{border:0;background:#2f6d50;color:white;padding:14px 18px;border-radius:12px;font-weight:700;font-size:16px;cursor:pointer}.error{background:#fff0f0;border:1px solid #efc5c5;padding:12px;border-radius:10px;margin-bottom:16px}@media(max-width:680px){.grid{grid-template-columns:1fr}}</style>
</head>
<body><div class="wrap"><h1>Form Minat Temoe Tumbuh</h1><p>Bantu kami merancang daycare yang benar-benar sesuai kebutuhan keluarga Cilegon–Serang.</p>
<div class="card">
@if($errors->any())<div class="error">Mohon cek kembali data yang diisi.</div>@endif
<form method="post" action="{{ route('interest.store') }}">@csrf
<div class="grid"><div class="field"><label>Nama orang tua *</label><input name="parent_name" value="{{ old('parent_name') }}" required></div><div class="field"><label>WhatsApp *</label><input name="whatsapp" value="{{ old('whatsapp') }}" required></div></div>
<div class="grid"><div class="field"><label>Email</label><input type="email" name="email" value="{{ old('email') }}"></div><div class="field"><label>Nama anak</label><input name="child_name" value="{{ old('child_name') }}"></div></div>
<div class="grid"><div class="field"><label>Usia anak</label><input type="number" min="0" max="12" name="child_age" value="{{ old('child_age') }}"></div><div class="field"><label>Kota</label><select name="city"><option value="">Pilih</option><option>Cilegon</option><option>Serang</option><option>Lainnya</option></select></div></div>
<div class="grid"><div class="field"><label>Kecamatan / area</label><input name="district" value="{{ old('district') }}"></div><div class="field"><label>Lokasi daycare yang diharapkan</label><input name="preferred_location" value="{{ old('preferred_location') }}"></div></div>
<div class="grid"><div class="field"><label>Kebutuhan jadwal</label><select name="preferred_schedule"><option value="">Pilih</option><option>Senin–Jumat full day</option><option>Beberapa hari per minggu</option><option>Half day</option><option>Fleksibel / insidental</option></select></div><div class="field"><label>Target mulai</label><input type="date" name="preferred_start_date" value="{{ old('preferred_start_date') }}"></div></div>
<div class="field"><label>Budget daycare per bulan</label><select name="budget_range"><option value="">Pilih</option><option>&lt; Rp1,5 juta</option><option>Rp1,5–2 juta</option><option>Rp2–2,5 juta</option><option>Rp2,5–3 juta</option><option>&gt; Rp3 juta</option></select></div>
<div class="field"><label><input type="checkbox" name="reservation_interest" value="1"> Saya tertarik mendapat prioritas reservasi / Founding Parents jika program dibuka.</label></div>
@foreach($attribution as $key => $value)<input type="hidden" name="{{ $key }}" value="{{ $value }}">@endforeach
<button type="submit">Kirim Minat Saya</button>
</form></div></div></body></html>
