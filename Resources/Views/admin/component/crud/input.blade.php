@if(empty($input['type']) || $input['type'] == 'text')
    <label class="label">
        <span class="legend">{{ $input['label'] }}:</span>
        <input type="{{ $input['type'] ?? 'text' }}"
            name="{{ $input['name'] }}"
            class="{{ (!empty($input['class'])) ? $input['class'] : '' }}"
            placeholder="{{ $input['placeholder'] ?? '' }}"
            value="{{ old($input['name']) ?? $input['value'] ?? ''}}"
            />
    </label>
@elseif($input['type'] == 'select')
    <label class="label">
        <span class="legend">{{ $input['label'] }}:</span>
        <select name="{{ $input['name'] }}">
            <option value="" selected>Selecione uma opção</option>
            @foreach($input['options'] as $option)
                <option value="{{ $option['uuid'] ?? $option['id'] }}"
                    {{ (old($input['name']) == ($option['uuid'] ?? $option['id'])) ? 'selected' : '' }}>
                    {{ $option['name'] }}</option>
            @endforeach
        </select>
    </label>
@endif
