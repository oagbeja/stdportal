@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img src="/img/s-img.jpg" alt="" class="rounded-circle">
        </div>
        <div class="col-9 pt-5">
            <div><h1>{{$user -> username}}</h1></div>
            <div class="d-flex">
                <div class="pr-5" ><strong>312</strong> posts</div>
                <div class="pr-5" ><strong>25k</strong> followers</div>
                <div class="pr-5"><strong>41</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">freecodeCamp.org</div>
            <div>We're a global page actually designed for testing. It is really interesting learning laravel from youTube Go. I wish everyone should get accompanied with it.</div>
            <div><a href="#">www.freecodecamp.org </a></div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-4">
            <img src="/img/s1.jpg" class="w-100" alt="" >
        </div>
        <div class="col-4">
            <img src="/img/s2.jpg" class="w-100" alt="" >
        </div>
        <div class="col-4">
            <img src="/img/s3.jpg" class="w-100" alt="" >
        </div>
    </div>
</div>
@endsection
