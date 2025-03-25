<div>
    <div class="border input-primary rounded">
        <select id="{{ $type }}" class="checkbox-select" wire:model="selected" multiple>
            @foreach($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    </div>

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
</div>

