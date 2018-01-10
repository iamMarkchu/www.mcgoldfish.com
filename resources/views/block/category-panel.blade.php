<div class="panel panel-default">
    <div class="panel-heading">热门分类</div>
    <div class="panel-body">
        @foreach($categories as $category)
            <a href="{{ route('category', ['id' => $category->id]) }}" class="btn btn-default btn-sm btn-category">{{ $category->category_name }}</a>
        @endforeach
    </div>
</div>