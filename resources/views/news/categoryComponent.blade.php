<div class="category">
    <a href="{{route('category', [ (($parentPath?$parentPath . '/':'') . $category['alias']) ] ) }}">
        {{$category['name']}}
    </a>

    @if(isset($category['child']))
        <div class="sub_category pl-4">
        @foreach($category['child'] as $sub_category)
            @component('news.categoryComponent', [
                "category" => $sub_category,
                "parentPath" => (($parentPath?$parentPath . '/':'') . $category['alias'])
            ])
            @endcomponent
        @endforeach
        </div>
    @endif

</div>
