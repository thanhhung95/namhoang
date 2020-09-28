<ul class="nav nav-second-level collapse">
    @foreach($usecase as $uc)
        @foreach($childs as $item)
            @if($item->id == $uc->id && $item->status == 1)
                <li class="{{strcmp(\Request::path(),$item->route) ? '' : 'active'}}">
                    <a href="{!! $item->route !!}">
                        <i class="{{$item->icon}}"></i>
                        <span class="nav-label"></span>
                        {{$item->name}}
                        @if(count($item->childs ) && $level < 2)
                            <span class="fa arrow"></span>
                        @endif
                    </a>
                    @if(count($item->childs) && $level < 2)
                        @include('Layouts.usecase-childs',['childs' => $item->childs, 'usecase' => $usecase, 'level' => $level+1])
                    @endif
                </li>
                @break
            @endif
        @endforeach
    @endforeach
</ul>