<div>
    <div wire:ignore class="border input-primary rounded">
        <select id="{{ $type }}" class="checkbox-select" wire:model="{{ $wireModel }}" multiple>
            @foreach ($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    </div>
</div>
@script
    <script type="module">
        new TomSelect("#subjects", {
            allowEmptyOption: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: "Subject",
            render: {
                no_results: function() {
                    return '<p>No results found</p>';
                }
            },
            plugins: {
                remove_button: {
                    title: 'Remove filter',
                    className: 'p-1'
                }
            }
        });
        new TomSelect("#levels", {
            allowEmptyOption: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: "Level",
            render: {
                no_results: function() {
                    return '<p>No results found</p>';
                }
            },
            plugins: {
                remove_button: {
                    title: 'Remove filter',
                    className: 'p-1'
                }
            }
        });
        new TomSelect("#styles", {
            allowEmptyOption: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: "Learning style",
            render: {
                no_results: function() {
                    return '<p>No results found</p>';
                }
            },
            plugins: {
                remove_button: {
                    title: 'Remove filter',
                    className: 'p-1'
                }
            }
        });
    </script>
@endscript
