@if(empty($input['type']) || $input['type'] == 'text')
    <label class="label">
        <span class="legend">{{ $input['label'] }}:</span>
        <input type="{{ $input['type'] ?? 'text' }}"
            name="{{ $input['name'] }}"
            placeholder="{{ $input['placeholder'] ?? '' }}"/>
    </label>
@elseif($input['type'] == 'select')
    <label class="label">
        <span class="legend">{{ $input['label'] }}:</span>
        <select name="{{ $input['name'] }}">
            @foreach($input['options'] as $option)
                <option value="{{ $option['uuid'] ?? $option['id'] }}">{{ $option['name'] }}</option>
            @endforeach
        </select>
    </label>
@endif
