@include('contact-form::fields._label', ['field' => $field, 'id' => $id])
<select class="cf-input" id="{{ $id }}" name="{{ $key }}" @if (!empty($field['required'])) required @endif>
    <option value="">{{ $field['placeholder'] ?? __('Choose...') }}</option>
    @foreach (\Shazzoo\ContactForm\Support\FieldTypes::choices($field) as $choice)
        <option value="{{ $choice }}" @selected(old($key) === $choice)>{{ $choice }}</option>
    @endforeach
</select>
