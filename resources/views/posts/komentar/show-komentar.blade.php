<div class="my-3">
    <ul>
        @foreach($comment as $items)
            <li>
                <small class="text-danger ">{{$items->created_at}}</small> {{($items->komentar)}}
            </li>
        @endforeach
    </ul>
</div>