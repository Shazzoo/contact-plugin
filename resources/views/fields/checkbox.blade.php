<label class="cf-checkbox" for="{{ $id }}">
    <input id="{{ $id }}" type="checkbox" name="{{ $inputName }}" value="1"
        @checked(old($key)) @if (!empty($field['required'])) required @endif>
    <span>{{ $field['label'] ?? $field['name'] }}@if (!empty($field['required']))<span class="cf-required" aria-hidden="true">*</span>@endif</span>
</label>
