<div class="form-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::Label('category', 'Select Category:') !!}
                <select name="category" class="form-control" id="category">
                    <option value="" disabled> Select Category </option>
                    <option value="1" {{ $product->category == 1 ? 'selected' : '' }}>Courses </option>
                    <option value="5" {{ $product->category == 5 ? 'selected' : '' }}>Upcoming Training </option>
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

        <div class="col-md-12" id="year_sec" style="display: none;">
            <div class="form-group">
                {!! Form::Label('year', 'Select Year:') !!}
                <select name="year" id="year" class="form-control"></select>
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
                {!! Form::label('product_title', 'Course Title') !!}
                {!! Form::text(
                    'product_title',
                    null,
                    'required' == 'required' ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Course Title'] : ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="col-md-12" id="date_range" style="display: none;">
            <div class="form-group">
                {!! Form::label('date_range', 'Date Range') !!}
                {!! Form::text(
                    'date_range',
                    null,
                    ['class' => 'form-control', 'placeholder' => 'Enter date range', 'id' => 'daterange']
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('location', 'Location') !!}
                {!! Form::text(
                    'location',
                    null,
                    ['class' => 'form-control', 'placeholder' => 'Enter location']
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('price', 'Price') !!}
                {!! Form::number(
                    'price',
                    null,
                    ['class' => 'form-control', 'required' => 'required', 'step' => '0.01', 'placeholder' => 'Enter Price']
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('level', 'Level of Course') !!}
                {!! Form::select(
                    'level',
                    ['Beginner' => 'Beginner', 'Intermediate' => 'Intermediate', 'Advanced' => 'Advanced'],
                    null,
                    ['class' => 'form-control', 'required' => 'required']
                ) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!! Form::label('duration', 'Duration') !!}
                {!! Form::text(
                    'duration',
                    null,
                    'required' == 'required' ? ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Enter Duration'] : ['class' => 'form-control'],
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
                {!! Form::Label('item', 'Select Course Content') !!}
                <select name="course_content" id="course_content" class="form-control">
                    <option value="" disabled selected>--Select--</option>
                    @foreach ($course as $item)
                        <option value="{{ $item->id }}">{{ $item->product_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>
</div>

<div class="form-actions text-right pb-0">
    {!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        var selectedCategoryId = "{{ $product->category }}";
        var selectedSubcategoryId = "{{ $product->subcategory }}";
        var selectedYear = "{{ $product->year }}";

        function populateYearDropdown(selectedYear) {
            var currentYear = new Date().getFullYear();
            var selectElement = $('#year');
            selectElement.empty();

            for (var i = 0; i <= 5; i++) {
                var year = currentYear + i;
                var optionElement = $('<option></option>')
                    .attr('value', year)
                    .text(year);

                if (year == selectedYear) {
                    optionElement.attr('selected', 'selected');
                }

                selectElement.append(optionElement);
            }
        }

        if (selectedCategoryId != '0') {
            $('#category').val(selectedCategoryId);
            $('#subcategory_sec').show();

            if (selectedCategoryId == '5') {
                // $('#year_sec').show();
                $('#date_range').show();
                // $('#year').attr("required", "true");
                $('#daterange').attr("required", "true");
                populateYearDropdown(selectedYear);
            }else{
                // $('#year_sec').hide();
                $('#date_range').hide();
                // $('#year').removeAttr("required");
                $('#daterange').removeAttr("required");
            }

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

            if (get_id == '5') {
                // $('#year_sec').show();
                $('#date_range').show();
                // $('#year').attr("required", "true");
                $('#daterange').attr("required", "true");
                populateYearDropdown(selectedYear);
            }else{
                // $('#year_sec').hide();
                $('#date_range').hide();
                // $('#year').removeAttr("required");
                $('#daterange').removeAttr("required");
            }

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

    });

</script>
