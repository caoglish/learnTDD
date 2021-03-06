@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#"> {{$thread->creator->name}}</a> posted: {{$thread->title}}</div>

                <div class="card-body">

                        {{$thread->body}}



                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <h2>Reply:    </h2>
            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach
        </div>
    </div>

    @if(auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
        <form method="POST" action="{{$thread->path().'/replies'}}">
            {{ csrf_field() }}
            <div class="form-group">
                <textarea name="body" id="body" class="form-control" placehoader="Have something"></textarea>
            </div>
            <button class="btn btn-default">POST</button>
        </form>

        </div>
    </div>
    @else
        <p class='text-center'>please <a href="{{route("login")}}">sign in</a> to participate in this discussion.</p>
    @endif
</div>
@endsection
