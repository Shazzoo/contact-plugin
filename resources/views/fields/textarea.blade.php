@include('contact-form::fields._label', ['field' => $field, 'id' => $id])
<textarea class="cf-textarea" id="{{ $id }}" name="{{ $key }}"
    @if (!empty($field['required'])) required @endif
    @if (!empty($field['placeholder'])) placeholder="{{ $field['placeholder'] }}" @endif>{{ old($key) }}</textarea>
