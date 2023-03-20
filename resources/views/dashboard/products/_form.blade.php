@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <x-form.input required="true" name="name" label="Product Name" :value="$product->name" />
        </div>
        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select id="category_id" name="category_id" class="form-control ">
                <option value="">No Category</option>
                @foreach(\App\Models\Category::all() as $category)
                <option value="{{$category->id}}" @if ($category->id == old('category_id' , $product->category_id)) selected @endif>{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <x-form.textarea label="Description" name="description" :value="$product->description"/>
        </div>

        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="price" step="0.1" type="number" label="Price" :value="$product->price" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="compare_price" step="0.1" type="number" label="Compare Price" :value="$product->compare_price" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="cost" step="0.1" type="number" label="Cost" :value="$product->cost" />
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="quantity" step="0.1" type="number" label="Quantity" :value="$product->quantity" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="sku" label="SKU" :value="$product->sku" />
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.input name="barcode" label="Barcode" :value="$product->barcode" />
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <x-form.select name="status" :options="$status_options" required="1" label="Status" />
                   
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="availability">Availability</label>
                    <select id="availability" name="availability" class="form-control ">
                        <option value="">Select One</option>
                        @foreach($availabilities as $key => $availability)
                        <option value="{{$key}}" @if ($key==old('availability' , $product->availability)) selected @endif >{{$availability}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="image">Thumbnail</label>
            <div class="mb-2">
                @if ($product->image)
                {{--
                    <img src="{{ asset('/storage/'.$product->image)}}" alt="nn" height="150">
                --}}
                <img id="thumbnail" src="{{ Storage::disk('public')->url($product->image) }}" alt="nn" height="150">
                @else
                <img id="thumbnail" src="{{ asset('/images/product.jpg')}}" alt="nn" height="150">
                @endif
            </div>
            <input type="file" style="display:none" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
            <p class="invalid-feedback">{{$message}}</p>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">{{$button}}</button>
            <a href="{{route('dashboard.products.index')}}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

@section('script')
<script>
    document.getElementById('thumbnail').addEventListener('click', function(e) {
        document.getElementById('image').click();
    })
    document.getElementById('image').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            document.getElementById('thumbnail').src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endSection