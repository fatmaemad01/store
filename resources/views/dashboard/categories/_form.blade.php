@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <x-form.input name="name" label="Category Name" :value="$category->name"/>
        </div>
        <div class="form-group mb-3">
            <label for="parent_id">Category Parent</label>
            <select id="parent_id" name="parent_id" class="form-control ">
                <option value="">No Parent</option>
                @foreach($parents as $parent)
                <option value="{{$parent->id}}" @if ($parent->id == old('parent_id' , $category->parent_id)) selected @endif>{{$parent->name}}</option>
                @endforeach


            </select>

        </div>
        <div class="form-group mb-3">
            <x-form.textarea label="Description" name="description" :value="$category->description"/>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="image">Thumbnail</label>
            <div class="mb-2">
                @if ($category->image)
                {{--
                    <img src="{{ asset('/storage/'.$category->image)}}" alt="nn" height="150">
                --}}
                <img id="thumbnail" src="{{ Storage::disk('public')->url($category->image) }}" alt="nn" height="150">
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
            <a href="{{route('dashboard.categories.index')}}" class="btn btn-light">Cancel</a>
        </div>
    </div>
</div>

@section('script')
<script>
    document.getElementById('thumbnail').addEventListener('click' , function(e){
        document.getElementById('image').click();
    })
    document.getElementById('image').addEventListener('change', function(e){
        if(this.files && this.files[0]){
           document.getElementById('thumbnail').src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endSection