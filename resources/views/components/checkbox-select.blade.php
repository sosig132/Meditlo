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
        const subjectsSelect = new TomSelect("#subjects", {
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
            },
            onItemAdd: function() {
                this.placeholder = '';
            },
            onItemRemove: function() {
                if (this.items.length === 0) {
                    this.placeholder = "Subject";
                }
            }
        });
        
        const levelsSelect = new TomSelect("#levels", {
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
            },
            onItemAdd: function() {
                this.placeholder = '';
            },
            onItemRemove: function() {
                if (this.items.length === 0) {
                    this.placeholder = "Level";
                }
            }
        });
        
        const stylesSelect = new TomSelect("#styles", {
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
            },
            onItemAdd: function() {
                this.placeholder = '';
            },
            onItemRemove: function() {
                if (this.items.length === 0) {
                    this.placeholder = "Learning style";
                }
            }
        });

        
    </script>
@endscript
