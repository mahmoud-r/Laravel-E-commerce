<script>

//seo
$(document).ready(function() {
    $('input[data-counter], textarea[data-counter]').on('input keyup keypress focus blur', function() {
        var $this = $(this);
        var maxLength = parseInt($this.data('counter'));
        var currentLength = $this.val().length;
        var $counter = $this.next('.charcounter');

        $counter.text('(' + currentLength + '/' + maxLength + ')');

        if (currentLength > maxLength) {
            $counter.addClass('text-danger');
        } else {
            $counter.removeClass('text-danger');
        }
    });
});

//Toggle seo section
$(document).on('click','.btn-trigger-show-seo-detail',function (){
    $('.seo-edit-section').fadeToggle()
})


//Enable max order
$('#max_check').on('change',function (){
    if(this.checked) {
        $('#max_order').val(0)
        $('#max_order').prop('readonly',true)
    }else {
        $('#max_order').prop('readonly',false)
    }

})

//related Products
$('.relatedProducts').select2({
    ajax: {
        url: '{{ route('products.getProducts')}}',
        dataType: 'json',
        tags: true,
        multiple: true,
        minimumInputLength: 3,
        processResults: function (data) {
            return {
                results: data.tags
            };
        }
    }
});


//Generate Slug
$(document).on('click','#generate-slug',function (){
    var name = $('#title').val()
    $.ajax({
        url:'{{Route('getslug')}}',
        type:'get',
        data:{title:name},
        dataType:'json',
        success:function (response){

            if(response['status']===true){
                $('#slug').val(response["slug"]);
            }

        }
    });
})

//Get subCategory and Attribute
$('#category_id').change(function (){
    var category_id = $(this).val();
    $.ajax({
        url:'{{route('getsubcategory')}}',
        type:'get',
        data:{category_id :category_id},
        dataType: 'json',
        success:function (response){
            $('#sub_category__id').find('option').not(':first').remove();
            $.each(response['subCategory'],function (key,item){

                $('#sub_category_id').append('<option value="' + item.id + '">' + item.name +'</option>');

            })
            loadAttributes(category_id);
            $('#AttributeCategoryId').val(category_id)
        },
        error:function (){
            console.log('something went wrong')
        }

    })
})

//Handel Error
function handleErrors(errors) {
    $('.error').removeClass('invalid-feedback').html('');
    $("input[type='text'],input[type='number'],select").removeClass('is-invalid');

    $.each(errors, function (key, value) {
        $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(`${value}`);
    });}


//Toggle Flash Sale section
$(document).on('click','.btn-trigger-show-flash-sale',function (){
    $('.flash-sale-section').fadeToggle()
})

//Flash Sale Date
$(document).ready(function (){

    flatpickr("#flash_sale_expiry_date", {
        dateFormat: "Y-m-d H:i:s",
        enableTime: true,
    });


})

</script>


<!-- attribute Script-->
@include('admin.products.attributeScript')
