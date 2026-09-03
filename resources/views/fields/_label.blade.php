<label class="cf-label" for="{{ $id }}">
    {{ $field['label'] ?? $field['name'] }}@if (!empty($field['required']))<span class="cf-required" aria-hidden="true">*</span>@endif
</label>
