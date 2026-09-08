@extends('layouts.admin')
@section('title','Form Minat')
@section('topbar','Form Builder')
@section('content')
<div class="heading">
    <div><h1>Form Minat</h1><p>Atur section, copy, pilihan, dan pertanyaan yang tampil pada halaman pendaftaran minat.</p></div>
    <a class="btn btn-outline" target="_blank" href="{{ route('interest.create') }}">Preview Form ↗</a>
</div>

<div class="heading" style="margin-top:10px"><div><h2 style="margin:0">Pengaturan Section</h2><p>Section aktif ditampilkan mengikuti angka urutan. Section inti yang dilindungi tetap bisa diganti judul, deskripsi, dan urutannya.</p></div></div>
<div class="grid grid-2" style="align-items:start;margin-bottom:32px">
    <div class="stack">
        @foreach($sections as $section)
            <div class="card card-pad">
                <form method="post" action="{{ route('admin.form-fields.sections.update', $section) }}">
                    @csrf @method('PUT')
                    <div class="actions" style="justify-content:space-between;margin-bottom:14px">
                        <div><strong>{{ $section->title }}</strong><div class="help">{{ $section->section_key }} · urutan {{ $section->sort_order }}</div></div>
                        <div class="actions">@if($section->is_protected)<span class="badge">Section inti</span>@endif<label class="help"><input type="checkbox" name="is_active" value="1" @checked($section->is_active) @disabled($section->is_protected)> Aktif</label></div>
                    </div>
                    <div class="grid grid-2">
                        <div class="field"><label>Judul section</label><input class="input" name="title" value="{{ $section->title }}" required></div>
                        <div class="field"><label>Urutan</label><input class="input" type="number" min="0" max="9999" name="sort_order" value="{{ $section->sort_order }}"></div>
                    </div>
                    <div class="field" style="margin-top:12px"><label>Deskripsi singkat (opsional)</label><textarea class="textarea" name="description" rows="2" style="min-height:76px">{{ $section->description }}</textarea></div>
                    <button class="btn btn-primary" style="margin-top:14px">Simpan Section</button>
                </form>
                @unless($section->is_protected)
                    <form method="post" action="{{ route('admin.form-fields.sections.destroy', $section) }}" style="margin-top:9px" onsubmit="return confirm('Hapus section ini beserta semua pertanyaan di dalamnya? Jawaban historis pada lead tetap tersimpan.')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus Section</button></form>
                @endunless
            </div>
        @endforeach
    </div>
    <form class="card card-pad" method="post" action="{{ route('admin.form-fields.sections.store') }}">
        @csrf
        <h3 class="section-title">Tambah Section Baru</h3>
        <div class="stack">
            <div class="field"><label>Section key</label><input class="input" name="section_key" value="{{ old('section_key') }}" required pattern="[a-z0-9_]+" placeholder="kebutuhan_khusus"><div class="help">ID unik: huruf kecil, angka, dan underscore. Tidak tampil ke pengunjung.</div></div>
            <div class="field"><label>Judul section</label><input class="input" name="title" value="{{ old('title') }}" required placeholder="Ceritakan kebutuhan khusus si kecil"></div>
            <div class="field"><label>Deskripsi singkat (opsional)</label><textarea class="textarea" name="description" rows="3">{{ old('description') }}</textarea></div>
            <div class="field"><label>Urutan</label><input class="input" type="number" min="0" max="9999" name="sort_order" value="{{ old('sort_order', 100) }}"></div>
            <label class="help"><input type="checkbox" name="is_active" value="1" checked> Langsung aktif</label>
            <button class="btn btn-primary">Tambah Section</button>
        </div>
    </form>
</div>

<form class="stack" method="post" action="{{ route('admin.form-fields.content.update') }}" style="margin-bottom:22px">
    @csrf @method('PUT')
    <div class="card card-pad" style="background:#edf3e9"><div class="actions" style="justify-content:space-between;align-items:flex-start"><div><strong style="font-size:17px">Konten & Label Field Inti</strong><div class="help" style="margin-top:6px">Perubahan di bawah langsung dipakai pada Form Minat. Pilihan kota, jadwal, dan budget ditulis satu pilihan per baris.</div></div><button class="btn btn-primary">Simpan Seluruh Konten</button></div></div>
    <div class="grid grid-2" style="align-items:start">
        @foreach($contentGroups as $group)
            <section class="card card-pad">
                <h3 class="section-title">{{ $group['title'] }}</h3><p class="help" style="margin-top:-7px;margin-bottom:16px">{{ $group['description'] }}</p>
                <div class="stack">
                    @foreach($group['fields'] as $item)
                        <div class="field"><label>{{ $item['label'] }}</label>
                            @if(in_array($item['type'] ?? 'text', ['textarea','options'], true))
                                <textarea class="textarea" name="{{ $item['key'] }}" rows="{{ ($item['type'] ?? null) === 'options' ? 6 : 3 }}">{{ old($item['key'], $content[$item['key']]) }}</textarea>
                                @if(($item['type'] ?? null) === 'options')<div class="help">Satu pilihan per baris. Pilihan ini juga dipakai untuk validasi data saat formulir dikirim.</div>@endif
                            @else
                                <input class="input" name="{{ $item['key'] }}" value="{{ old($item['key'], $content[$item['key']]) }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
    <div class="actions" style="justify-content:flex-end"><button class="btn btn-primary">Simpan Seluruh Konten Form Minat</button></div>
</form>

<div class="heading" style="margin-top:32px"><div><h2 style="margin:0">Semua Field Form</h2><p>Field inti dan field tambahan dikelola di tempat yang sama: bisa diedit, dipindahkan, dinonaktifkan, ditambah, atau dihapus.</p></div></div>
<div class="grid grid-2" style="align-items:start">
    <div class="stack">
        @forelse($fields as $field)
            <div>
                <form class="card card-pad" method="post" action="{{ route('admin.form-fields.update', $field) }}">
                    @csrf @method('PUT')
                    <div class="actions" style="justify-content:space-between"><div><strong>{{ $field->label }}</strong><div class="help">{{ $field->field_key }} · {{ $field->type }} · {{ $field->isCore() ? 'field inti' : 'field tambahan' }}</div></div><div class="actions">@if($field->isCore())<span class="badge">Field inti</span>@endif<label class="help"><input type="checkbox" name="is_required" value="1" @checked($field->is_required)> Wajib</label><label class="help"><input type="checkbox" name="is_active" value="1" @checked($field->is_active)> Aktif</label></div></div>
                    <div class="grid grid-2" style="margin-top:14px">
                        <div class="field"><label>Section</label><select class="select" name="section_key" required>@foreach($sections as $section)<option value="{{ $section->section_key }}" @selected($field->section_key === $section->section_key)>{{ $section->title }}</option>@endforeach</select></div>
                        <div class="field"><label>Label</label><input class="input" name="label" value="{{ $field->label }}" required></div>
                        <div class="field"><label>Tipe</label><select class="select" name="type">@foreach($field->allowedTypes() as $type)<option @selected($field->type===$type)>{{ $type }}</option>@endforeach</select></div>
                        <div class="field"><label>Placeholder</label><input class="input" name="placeholder" value="{{ $field->placeholder }}"></div>
                        <div class="field"><label>Urutan dalam section</label><input class="input" type="number" name="sort_order" value="{{ $field->sort_order }}"></div>
                    </div>
                    <div class="field" style="margin-top:12px"><label>Help text</label><input class="input" name="help_text" value="{{ $field->help_text }}"></div>
                    <div class="field" style="margin-top:12px"><label>Options (satu pilihan per baris)</label><textarea class="textarea" name="options_text">{{ $field->options ? implode("\n", $field->options) : '' }}</textarea></div>
                    <button style="margin-top:14px" class="btn btn-primary">Simpan Field</button>
                </form>
                <form method="post" action="{{ route('admin.form-fields.destroy', $field) }}" style="margin-top:9px" onsubmit="return confirm('Hapus field ini dari Form Minat? Data lead yang sudah tersimpan tidak ikut terhapus.')">@csrf @method('DELETE')<button class="btn btn-danger">Hapus {{ $field->label }}</button></form>
            </div>
        @empty
            <div class="card empty">Belum ada field. Tambahkan field lalu pilih section tempat field ditampilkan.</div>
        @endforelse
    </div>
    <form class="card card-pad" method="post" action="{{ route('admin.form-fields.store') }}">
        @csrf
        <h3 class="section-title">Tambah Field</h3>
        <div class="stack">
            <div class="field"><label>Section</label><select class="select" name="section_key" required>@foreach($sections as $section)<option value="{{ $section->section_key }}" @selected(old('section_key') === $section->section_key)>{{ $section->title }}</option>@endforeach</select><div class="help">Buat section baru terlebih dahulu bila pilihan yang dibutuhkan belum tersedia.</div></div>
            <div class="field"><label>Field Key</label><input class="input" name="field_key" value="{{ old('field_key') }}" required pattern="[a-z0-9_]+" placeholder="work_arrangement"><div class="help">Unik, huruf kecil/angka/underscore. Untuk mengembalikan field inti yang terhapus, gunakan key aslinya.</div></div>
            <div class="field"><label>Label pertanyaan</label><input class="input" name="label" value="{{ old('label') }}" required placeholder="Bagaimana pola kerja orang tua?"></div>
            <div class="field"><label>Tipe jawaban</label><select class="select" name="type">@foreach(['text','email','tel','number','date','select','radio','checkbox','textarea'] as $type)<option @selected(old('type') === $type)>{{ $type }}</option>@endforeach</select></div>
            <div class="field"><label>Placeholder</label><input class="input" name="placeholder" value="{{ old('placeholder') }}"></div>
            <div class="field"><label>Help text</label><input class="input" name="help_text" value="{{ old('help_text') }}"></div>
            <div class="field"><label>Options</label><textarea class="textarea" name="options_text" placeholder="WFO&#10;Hybrid&#10;WFH">{{ old('options_text') }}</textarea></div>
            <div class="field"><label>Urutan dalam section</label><input class="input" type="number" name="sort_order" value="{{ old('sort_order', 100) }}"></div>
            <div class="actions"><label class="help"><input type="checkbox" name="is_required" value="1" @checked(old('is_required'))> Wajib</label><label class="help"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', true))> Aktif</label></div>
            <button class="btn btn-primary">Tambah Field</button>
        </div>
    </form>
</div>
@endsection
