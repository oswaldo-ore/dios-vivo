@foreach ($subcategories as $subcategory)
    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
    @if ($subcategory->categories->count() > 0)
        @include('admin.category.sub-category', ['subcategories' => $subcategory->categories])
    @endif
@endforeach
