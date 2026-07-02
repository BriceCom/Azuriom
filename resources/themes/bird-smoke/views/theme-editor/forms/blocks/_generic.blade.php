@php
    $paramDefinitions = isset($paramDefinitions) && is_array($paramDefinitions)
        ? $paramDefinitions
        : (is_array($block['params'] ?? null) ? $block['params'] : []);
    $images = isset($images) && is_array($images) ? $images : [];
    $jsonFlags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES;
@endphp

@if(count($paramDefinitions) === 0)
    <p class="te-help mb-0">Aucun paramètre éditable pour ce bloc.</p>
@else
    <div class="te-modal-form">
        @foreach($paramDefinitions as $definition)
            @php
                $key = is_array($definition) ? ($definition['key'] ?? null) : null;
                $label = is_array($definition) ? ($definition['label'] ?? null) : null;
                $type = is_array($definition) ? ($definition['type'] ?? 'text') : 'text';
                $advanced = (bool) (is_array($definition) ? ($definition['advanced'] ?? false) : false);
                $hidden = (bool) (is_array($definition) ? ($definition['hidden'] ?? false) : false);
                $options = is_array($definition) ? ($definition['options'] ?? []) : [];
                $itemFields = is_array($definition) ? ($definition['item_fields'] ?? []) : [];
                $itemDefaults = is_array($definition) ? ($definition['item_defaults'] ?? []) : [];
                $wrapperClass = 'te-field'.($advanced ? ' te-field-advanced' : '');
            @endphp

            @if(!is_string($key) || $key === '' || !is_string($label) || $label === '' || $hidden)
                @continue
            @endif

            @if($type === 'list')
                <div class="{{ $wrapperClass }}">
                    <span class="te-field-label">{{ $label }}</span>
                    <div
                        class="te-list-editor"
                        data-block-param="{{ $key }}"
                        data-block-type="list"
                        data-list-editor="1"
                        data-list-definitions="{{ e(json_encode($itemFields, $jsonFlags)) }}"
                        data-list-defaults="{{ e(json_encode($itemDefaults, $jsonFlags)) }}"
                    >
                        <div class="te-list-items" data-list-items></div>
                        <button type="button" class="te-btn te-btn-success te-list-add" data-list-add>Nouveau +</button>
                    </div>
                </div>
            @elseif($type === 'textarea')
                <label class="{{ $wrapperClass }}">
                    <span class="te-field-label">{{ $label }}</span>
                    <textarea class="te-input" rows="3" data-block-param="{{ $key }}" data-block-type="textarea"></textarea>
                </label>
            @elseif($type === 'select')
                <label class="{{ $wrapperClass }}">
                    <span class="te-field-label">{{ $label }}</span>
                    <select class="te-input" data-block-param="{{ $key }}" data-block-type="select">
                        @foreach(is_array($options) ? $options : [] as $option)
                            <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </select>
                </label>
            @elseif($type === 'image')
                <label class="{{ $wrapperClass }}">
                    <span class="te-field-label">{{ $label }}</span>
                    <select class="te-input" data-block-param="{{ $key }}" data-block-type="image" data-te-image-select="true">
                        <option value="">Aucune image</option>
                        @foreach($images as $image)
                            @php
                                $imageName = is_array($image) ? ($image['name'] ?? null) : null;
                                $imageFile = is_array($image) ? ($image['file'] ?? null) : null;
                            @endphp
                            @if(is_string($imageFile) && $imageFile !== '')
                                <option value="{{ $imageFile }}">{{ $imageName ?: $imageFile }} ({{ $imageFile }})</option>
                            @endif
                        @endforeach
                    </select>
                </label>
            @elseif($type === 'toggle')
                <label class="{{ $wrapperClass }} te-field-inline">
                    <span class="te-field-label">{{ $label }}</span>
                    <input class="te-input" type="checkbox" data-block-param="{{ $key }}" data-block-type="toggle">
                </label>
            @else
                <label class="{{ $wrapperClass }}">
                    <span class="te-field-label">{{ $label }}</span>
                    <input
                        class="te-input"
                        type="{{ $type === 'number' ? 'number' : ($type === 'url' ? 'url' : 'text') }}"
                        data-block-param="{{ $key }}"
                        data-block-type="{{ $type }}"
                        @if($type === 'number' && isset($definition['min'])) min="{{ $definition['min'] }}" @endif
                        @if($type === 'number' && isset($definition['max'])) max="{{ $definition['max'] }}" @endif
                    >
                </label>
            @endif
        @endforeach
    </div>
@endif
