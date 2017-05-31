<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript">
    CKEDITOR.replace('description-editor');
    CKEDITOR.replace('page-editor');

    $fieldSelectorInput = $('#field-selector');
    $productNumberInput = $('#product-number');

    $fieldSelectorInput.on('change', function() {
        $.ajax({
            url: "{{ route('admin.content::content') }}",
            data: { block: this.value },
            dataType: 'json',
            success: function(data) {
                var content = data.payload;

                CKEDITOR.instances['page-editor'].setData(content.content);
                $('#step-2').show();
            }
        });
    });

    $productNumberInput.on('input', function () {
        if (this.value.length == 7) {
            $.ajax({
                url: "{{ route('admin.content::description') }}",
                data: { product: this.value },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    var content = data.payload;

                    CKEDITOR.instances['description-editor'].setData(content.value);
                }
            });
        }
    });
</script>