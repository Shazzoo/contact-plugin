@include('contact-form::fields._label', ['field' => $field, 'id' => $id])
<input class="cf-input" id="{{ $id }}" type="number" name="{{ $inputName }}"
    value="{{ old($key) }}" @if (!empty($field['required'])) required @endif
    @if (!empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif>
