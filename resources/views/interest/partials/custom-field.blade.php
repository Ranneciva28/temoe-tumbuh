<div class="field {{ in_array($field->type, ['textarea', 'radio', 'checkbox', 'hidden'], true) ? 'field-wide' : '' }}">
    <label>{{ $field->label }} @if($field->is_required) * @endif</label>
    @if($field->type === 'textarea')
        <textarea class="textarea" name="{{ $field->inputName() }}" @required($field->is_required) placeholder="{{ $field->placeholder }}">{{ old($field->oldInputKey()) }}</textarea>
    @elseif(in_array($field->type, ['select', 'radio'], true))
        @if($field->type === 'select')
            <select class="select" name="{{ $field->inputName() }}" @required($field->is_required)>
                <option value="">{{ $field->placeholder ?: 'Pilih' }}</option>
                @foreach($field->options ?? [] as $option)<option value="{{ $option }}" @selected(old($field->oldInputKey()) === $option)>{{ $option }}</option>@endforeach
            </select>
        @else
            @foreach($field->options ?? [] as $option)<label class="choice"><input type="radio" name="{{ $field->inputName() }}" value="{{ $option }}" @checked(old($field->oldInputKey()) === $option) @required($field->is_required)><span>{{ $option }}</span></label>@endforeach
        @endif
    @elseif($field->type === 'checkbox')
        @foreach($field->options ?? [] as $option)<label class="choice"><input type="checkbox" name="{{ $field->inputName() }}[]" value="{{ $option }}" @checked(in_array($option, (array) old($field->oldInputKey(), []), true))><span>{{ $option }}</span></label>@endforeach
    @elseif($field->type === 'hidden')
        <input type="hidden" name="{{ $field->inputName() }}" value="{{ old($field->oldInputKey(), $field->placeholder) }}">
    @else
        <input class="input" type="{{ in_array($field->type, ['email', 'tel', 'number', 'date'], true) ? $field->type : 'text' }}" name="{{ $field->inputName() }}" value="{{ old($field->oldInputKey()) }}" @required($field->is_required) placeholder="{{ $field->placeholder }}">
    @endif
    @if($field->help_text)<div class="help">{{ $field->help_text }}</div>@endif
</div>
