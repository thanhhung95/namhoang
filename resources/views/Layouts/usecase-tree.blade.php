<?php
$level  =   1;
$root   =   \App\UseCase::where('parent_id',0)->orderBy('ordering','asc')->get();
$user   =   \Illuminate\Support\Facades\Auth::user();
$flag   =   false;

foreach ($user->Role as $item){
    if ($item->id == 101){
        $flag   =   true;
    }
}
if ($flag){
    $usecase    =   \App\UseCase::where('status','<>',2)->orderBy('ordering','asc')->get();
} else {
    $usecase    =   \Illuminate\Support\Facades\DB::table('view_table_users_usecase')
        ->where('user_id',$user->id)
        ->where('status','<>',2)
        ->where('states',1)
        ->orderBy('ordering','asc')
        ->get();
}
?>
@foreach($root as $item)
    @foreach($usecase as $uc)
        @if($item->id == $uc->id)
            <li>
                <a href="{!! $item->route !!}">
                    <i class="{{$item->icon}}"></i>
                    <span class="nav-label">{{$item->name}}</span>
                    @if(count($item->childs))
                        <span class="fa arrow"></span>
                    @endif
                </a>
                @if(count($item->childs))
                    @include('Layouts.usecase-childs',['childs' => $item->childs, 'usecase' => $usecase, 'level' => $level+1])
                @endif
            </li>
            @break
        @endif
    @endforeach
@endforeach
