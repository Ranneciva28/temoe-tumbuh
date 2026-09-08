<div class="field">
    <label>{{ $field->label }} @if($field->is_required) * @endif</label>
    @if($field->type === 'textarea')
        <textarea class="textarea" name="custom[{{ $field->field_key }}]" @required($field->is_required) placeholder="{{ $field->placeholder }}">{{ old('custom.'.$field->field_key) }}</textarea>
    @elseif(in_array($field->type, ['select', 'radio'], true))
        @if($field->type === 'select')
            <select class="select" name="custom[{{ $field->field_key }}]" @required($field->is_required)>
                <option value="">Pilih</option>
                @foreach($field->options ?? [] as $option)<option value="{{ $option }}" @selected(old('custom.'.$field->field_key) === $option)>{{ $option }}</option>@endforeach
            </select>
        @else
            @foreach($field->options ?? [] as $option)<label class="choice"><input type="radio" name="custom[{{ $field->field_key }}]" value="{{ $option }}" @checked(old('custom.'.$field->field_key) === $option) @required($field->is_required)><span>{{ $option }}</span></label>@endforeach
        @endif
    @elseif($field->type === 'checkbox')
        @foreach($field->options ?? [] as $option)<label class="choice"><input type="checkbox" name="custom[{{ $field->field_key }}][]" value="{{ $option }}" @checked(in_array($option, (array) old('custom.'.$field->field_key, []), true))><span>{{ $option }}</span></label>@endforeach
    @elseif($field->type === 'hidden')
        <input type="hidden" name="custom[{{ $field->field_key }}]" value="{{ old('custom.'.$field->field_key, $field->placeholder) }}">
    @else
        <input class="input" type="{{ in_array($field->type, ['email', 'tel', 'number', 'date'], true) ? $field->type : 'text' }}" name="custom[{{ $field->field_key }}]" value="{{ old('custom.'.$field->field_key) }}" @required($field->is_required) placeholder="{{ $field->placeholder }}">
    @endif
    @if($field->help_text)<div class="help">{{ $field->help_text }}</div>@endif
</div>
