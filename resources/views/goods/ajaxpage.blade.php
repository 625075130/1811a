<div id="ajax">
@if($talkinfo)
    <h3 id="pinglun">评论显示区</h3>
    @foreach($talkinfo as $v)
        <table class="pinglun list" >
            <p>{{$v->u_email}}</p><p>{{$v->level}}</p><p>{{$v->desc}}</p><p>{{$v->created_at}}</p>
        </table>
        </br>
    @endforeach
    {{ $talkinfo->links() }}
@endif
</div>