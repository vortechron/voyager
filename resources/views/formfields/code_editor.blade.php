@php
    $value = $dataTypeContent->{$row->field} ?? ($options->default ?? '');
    
    if (is_array($value)) {
        $value = json_encode($value, JSON_PRETTY_PRINT);
    }
@endphp


<div id="{{ $row->field }}" data-theme="{{ @$options->theme }}" data-language="{{ @$options->language }}"
    class="ace_editor min_height_200" name="{{ $row->field }}">{{ old($row->field, $value) }}</div>
<textarea name="{{ $row->field }}" id="{{ $row->field }}_textarea" class="hidden">{{ old($row->field, $value) }}</textarea>
