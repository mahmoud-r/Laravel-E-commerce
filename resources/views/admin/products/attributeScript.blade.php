<script>
    // Attributes
    $(document).on('click', '.remove-attribute', function() {
        $(this).closest('tr').remove();
    });

    function loadAttributes(categoryId) {
        $.ajax({
            url: '{{ route("attributes.getAllByCategory", ":id") }}'.replace(':id', categoryId),
            method: 'GET',
            success: function(response) {
                $('#attributesSection').html(response.html);
            },
            error: function(xhr) {
                console.log('Error loading attributes:', xhr);
            }
        });
    }

    $('#AttributeForm').submit(function (e){
        e.preventDefault();
        var formArray =$(this).serializeArray();
        $.ajax({
            url:'{{route('products.storeAttribute')}}',
            type : 'post',
            data:formArray,
            dataType:'json',
            success:function (response){
                if(response.status == true){

                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'],input[type='number'],select").removeClass('is-invalid')
                    var valuesSection = document.getElementById('attributesSection');
                    var html = response.html
                    valuesSection.insertAdjacentHTML('beforeend', html);

                    $('#Add_new_Attribute').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })

                }else {
                    handleErrors(response.errors);
                }

            },error:function (xhr, status, error){
                var response = JSON.parse(xhr.responseText);
                handleErrors(response.errors);
                if (response.errors['category_id']){
                    Toast.fire({
                        icon: 'error',
                        title: response.errors['category_id']
                    })
                }
                console.log('something went wrong');

            }
        })
    });

    $(document).on('click','.addNewAttrValue',function (){
        var Name =$(this).data('attrname')
        var Id =$(this).data('attrid')

        $('#AddNewValue #attributeID').val(Id)
        $('#AddNewValue #attributeName').val(Name)

        $('#AddNewValue').modal('show')
    })
    $('#AttributeValueForm').submit(function (e){
        e.preventDefault();
        var formArray =$(this).serializeArray();
        $.ajax({
            url:'{{route('products.storeAttributeValue')}}',
            type : 'post',
            data:formArray,
            dataType:'json',
            success:function (response){
                if(response.status == true){

                    $('.error').removeClass('invalid-feedback').html('');
                    $("input[type='text'],input[type='number'],select").removeClass('is-invalid')

                    var valuesSection = $('select[name="attributes['+response.attribute+']"]');
                    var value =`<option value="${response.value.id}" selected>${response.value.value}</option>`;
                    valuesSection.append(value);

                    $('#AddNewValue').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: response.msg
                    })

                }else {
                    handleErrors(response.errors);

                }

            },error:function (xhr, status, error){
                var response = JSON.parse(xhr.responseText);
                handleErrors(response.errors);

                console.log('something went wrong');

            }
        })
    });

</script>
