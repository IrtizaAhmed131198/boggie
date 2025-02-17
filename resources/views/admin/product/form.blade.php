<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::Label('category', 'Select Category:') !!}
                <select name="category" class="form-control" id="category">
                    <option value="" disabled> Select Category </option>
                    @foreach ($items as $key => $val_items)
                        <option value="{{ $val_items->id }}" {{ $val_items->id == $product->category ? 'selected' : '' }}> {{ $val_items->name }} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12" id="subcategory_sec">
            <div class="form-group">
                {!! Form::Label('item', 'Select Sub-Category:') !!}
                <select name="subcategory" id="subcategory" class="form-control">

                </select>
            </div>
        </div>

        {{-- <div class="row" style="margin-left: 0;">

            <div class="col-md-4">
                <div class="form-group">
                    <label> Category </label>
                    <input type="text" value="{{ App\Category::find($product->category)->name }}"
                        class="form-control" readonly />
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label> Sub-Category </label>
                    <input type="text" value="{{ App\Models\Subcategory::find($product->subcategory)->sub_category }}"
                        class="form-control" readonly />
                </div>
            </div>

        </div> --}}

        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('product_title', 'Product Title') !!}
                {!! Form::text(
                    'product_title',
                    null,
                    'required' == 'required' ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('price', 'Price') !!}
                {!! Form::text(
                    'price',
                    null,
                    'required' == 'required' ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('description', 'Description') !!}
                {!! Form::textarea(
                    'description',
                    null,
                    'required' == 'required'
                        ? ['class' => 'form-control', 'id' => 'summary-ckeditor', 'required' => 'required']
                        : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('image', 'Image') !!}
                <input class="form-control dropify" name="image" type="file" id="image"
                    {{ $product->image != '' ? "data-default-file = /$product->image" : '' }}
                    {{ $product->image == '' ? 'required' : '' }} value="{{ $product->image }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('additional_image', 'Gallary Image') !!}
                <div class="gallery Images">
                    @foreach ($product_images as $product_image)
                        <div class="image-single">
                            <img src="{{ asset($product_image->image) }}" alt="" id="image_id">
                            <button type="button" class="btn btn-danger" data-repeater-delete=""
                                onclick="getInputValue({{ $product_image->id }}, this);"> <i
                                    class="ft-x"></i>Delete</button>
                        </div>
                    @endforeach
                </div>
                <input class="form-control dropify" name="images[]" type="file" id="images"
                    {{ $product->additional_image != '' ? "data-default-file = /$product->additional_image" : '' }}
                    value="{{ $product->additional_image }}" multiple>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <div class="col-10">
                        {!! Form::label('colors', 'Colors') !!}
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-success btn-sm btn-block btn_add_color">+</button>
                    </div>
                </div>
                @php
                    $colors = (isset($product) && !is_null($product)) ? json_decode($product->colors) : [];
                @endphp
                <div class="row color-wrapper">
                    @foreach($colors as $color)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-10">
                                    <input type="color" class="form-control" name="colors[]" value="{{$color}}">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_color">-</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <div class="col-md-12">
            <h4 class="card-title" id="repeat-form">Add Variation</h4>
        </div>
        @foreach ($product->attributes as $pro_att_edits)
            <div class="col-md-12">
                <div data-repeater-list="attribute">
                    <div data-repeater-item="" class="row">
                        <input type="hidden" value="{{ $pro_att_edits->id }}" name="product_attribute[]">
                        <div class="form-group mb-1 col-sm-12 col-md-3">
                            <label for="email-addr">Attribute</label>
                            <br>
                            <select class="form-control" id="attribute_id" name="attribute_id[]" onchange="getval(this)"
                                disabled>
                                <option value="{{ $pro_att_edits->attribute_id }}">
                                    {{ $pro_att_edits->attribute->name }}</option>
                                <!-- @foreach ($att as $atts)
                                    <option value="{{ $atts->id }}">{{ $atts->name }}</option>
                                    @endforeach -->
                            </select>
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-3">
                            <label for="pass">value</label>
                            <br>
                            <select class="form-control value" id="value" name="value[]" disabled>
                                <option value="{{ $pro_att_edits->value }}">
                                    {{ $pro_att_edits->attributesValues->value }}</option>
                            </select>
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                            <label for="bio" class="cursor-pointer">Price</label>
                            <br>
                            <input type="number" name="v_price[]" class="form-control" id="price"
                                value="{{ $pro_att_edits->price }}">
                        </div>
                        <div class="form-group mb-1 col-sm-12 col-md-2">
                            <label for="bio" class="cursor-pointer">qty</label>
                            <br>
                            <input type="number" name="qty[]" class="form-control" id="qty"
                                value="{{ $pro_att_edits->qty }}">
                        </div>
                        <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                            <button onclick="deleteAttr({{ $pro_att_edits->id }}, this)" type="button"
                                class="btn btn-danger" data-repeater-delete=""> <i class="ft-x"></i>
                                Delete</button>
                        </div>

                        <hr>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="repeater-default col-md-12">
            <div data-repeater-list="attribute">
                <div data-repeater-item="" class="row">

                    <div class="form-group mb-1 col-sm-12 col-md-3">
                        <label for="email-addr">Attribute</label>
                        <br>
                        <select class="form-control" id="attribute_id" name="attribute_id" onchange="getval(this)">
                            @foreach ($att as $atts)
                                <option value="{{ $atts->id }}">{{ $atts->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-1 col-sm-12 col-md-3">
                        <label for="pass">value</label>
                        <br>
                        <select class="form-control value" id="value" name="value">

                        </select>
                    </div>
                    <div class="form-group mb-1 col-sm-12 col-md-2">
                        <label for="bio" class="cursor-pointer">Price</label>
                        <br>
                        <input type="number" name="v-price" class="form-control" id="price">
                    </div>
                    <div class="form-group mb-1 col-sm-12 col-md-2">
                        <label for="bio" class="cursor-pointer">qty</label>
                        <br>
                        <input type="number" name="qty" class="form-control" id="qty">
                    </div>
                    <div class="form-group col-sm-12 col-md-2 text-center mt-2">
                        <button type="button" class="btn btn-danger" data-repeater-delete=""> <i
                                class="ft-x"></i>
                            Delete</button>
                    </div>

                    <hr>
                </div>
            </div>
            <div class="form-group overflow-hidden">
                <div class="">
                    <button type="button" data-repeater-create="" class="btn btn-primary">
                        <i class="ft-plus"></i> Add
                    </button>
                </div>
            </div>
        </div> --}}
    </div>
</div>

<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        // Pre-selected category and subcategory values from the server
        var selectedCategoryId = "{{ $product->category }}";  // Replace this with your backend value
        var selectedSubcategoryId = "{{ $product->subcategory }}";  // Replace this with your backend value

        // Check if a category is already selected (for edit)
        if (selectedCategoryId != '0') {
            $('#category').val(selectedCategoryId); // Set pre-selected category
            $('#subcategory_sec').show(); // Show subcategory section if category is pre-selected

            // Fetch and populate subcategories based on selected category
            $.ajax({
                url: "{{ route('set_sub_category') }}",
                type: "get",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    get_id: selectedCategoryId
                },
                success: function (response) {
                    if (response.status) {
                        const options = response.getsub_category;
                        if (options.length > 0) {
                            $('#subcategory_sec').show(); // Show subcategory section if options exist
                            $('#subcategory').empty();
                            const selectElement = $('#subcategory');
                            const optionElement1 = $('<option></option>').attr('value', 0).text('----');
                            selectElement.append(optionElement1);

                            // Populate subcategory options
                            options.forEach((option) => {
                                const { id, sub_category } = option;
                                const optionElement = $('<option></option>').attr('value', id).text(sub_category);
                                selectElement.append(optionElement);
                            });

                            // Set the pre-selected subcategory
                            if (selectedSubcategoryId != '0') {
                                $('#subcategory').val(selectedSubcategoryId);
                            }
                        } else {
                            $('#subcategory_sec').hide(); // Hide subcategory section if no subcategories are returned
                        }
                    }
                }
            });
        }

        // Handle category change event
        $('#category').change(function () {
            var get_id = $('#category').val();

            if (get_id == '0') {
                $('#subcategory_sec').hide(500);
            } else {
                $('#subcategory_sec').show(500);
            }

            $.ajax({
                url: "{{ route('set_sub_category') }}",
                type: "get",
                dataType: "json",
                data: {
                    "_token": "{{ csrf_token() }}",
                    get_id: get_id
                },
                success: function (response) {
                    if (response.status) {
                        const options = response.getsub_category;
                        if (options.length > 0) {
                            $('#subcategory_sec').show(500); // Show subcategory section if options exist
                            $('#subcategory').empty();
                            const selectElement = $('#subcategory');
                            const optionElement1 = $('<option></option>').attr('value', 0).text('----');
                            selectElement.append(optionElement1);

                            // Populate subcategory options
                            options.forEach((option) => {
                                const { id, sub_category } = option;
                                const optionElement = $('<option></option>').attr('value', id).text(sub_category);
                                selectElement.append(optionElement);
                            });
                        } else {
                            $('#subcategory_sec').hide(500); // Hide subcategory section if no options exist
                        }
                    } else {
                        toastr.success(response.error);
                    }
                }
            });
        });


        $('.btn_add_color').on('click', function () {
            var colorCount = $('.color-wrapper input[type="color"]').length;

            if (colorCount < 3) {
                $('.color-wrapper').append(`<div class="col-12">
                                    <div class="row">
                                        <div class="col-10">
                                            <input type="color" class="form-control" name="colors[]" value="">
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-danger btn-sm btn-block btn_remove_color">-</button>
                                        </div>
                                    </div>
                                </div>`);
            } else {
                alert('You cannot add more than 3 colors.');
            }
        });

        // Function to remove a color input
        $('body').on('click', '.btn_remove_color', function () {
            $(this).parent().parent().parent().remove();
        });

    });

</script>
