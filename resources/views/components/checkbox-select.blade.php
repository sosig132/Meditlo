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
            placeholder: "Filtreaza dupa materie",
            render: {
                no_results: function() {
                    return '<p>Niciun rezultat gasit</p>';
                }
            },
            plugins: {
                remove_button: {
                    title: 'Sterge filtrul',
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
            placeholder: "Filtreaza dupa nivel",
            render: {
                no_results: function() {
                    return '<p>Niciun rezultat gasit</p>';
                }
            }
        });
        new TomSelect("#styles", {
            allowEmptyOption: true,
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            placeholder: "Filtreaza dupa stil de invatare",
            render: {
                no_results: function() {
                    return '<p>Niciun rezultat gasit</p>';
                }
            }
        });
    </script>
@endscript
