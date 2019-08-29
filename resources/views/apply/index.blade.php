@extends('layouts.app')
@section('content')

<div class="pt-5" >
    <div class="pt-4">
        <em><a href="/" class=" text-info">Home</a> >

        Apply</em>
    </div>
    <div class="row pt-3 ">
        @if(session('success2'))
            <div class="alert alert-success col-12">
                {!! session('success2') !!}
                <button class="btn btn-warning "  onclick="myModa2()" data-toggle="modal" data-target="#myModal" style="float:right"> View Form </button>
            </div>

        @else
        <div class=" col-8 ">
            <div class="text-dark font-weight-bold">
            <span class="fa-stack">
                <i class="far fa-circle fa-stack-2x"></i>
                <strong class="fa-stack-1x fa-stack-text text-info fa-inverse">1</strong>
            </span> Apply To Get RRR</div>
            <div class="card">
            
                @if(session('success'))
                    <div class="alert alert-success">
                        {!! session('success') !!}
                    </div>
                @else
                    <form action="/apply/submit" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row ">
                            <div class="col-4 offset-1">

                                <div class="form-group row">
                                    <label for="title" class="col-form-label">Title</label>

                                    <input id="title"
                                        type="text"
                                        class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                        name="title" placeholder="Mr.,Mrs.,Ms."
                                        value="{{ old('title') }}"
                                        autocomplete="title" autofocus >

                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="fname" class=" col-form-label">First Name</label>

                                    <input id="fname"
                                        type="text"
                                        class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}"
                                        name="fname" placeholder="Your FirstName"
                                        value="{{ old('fname') }}"
                                        autocomplete="fname" >

                                    @if ($errors->has('fname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="faculty" class=" col-form-label">Faculty</label>

                                    <select name="faculty" id="faculty" onchange="chgprog()"
                                    class="form-control{{ $errors->has('faculty') ? ' is-invalid' : '' }}">

                                        <option value="">Choose Faculty</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{$faculty->faculty_id}}" style="color:{{$faculty->faculty_color}}">{{$faculty->faculty_desc}}</option>
                                        @endforeach
                                    </select>


                                    @if ($errors->has('faculty'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('faculty') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row" id="prog_show">
                                    <label for="prog" class=" col-form-label">Programme</label>

                                    <select name="prog" id="prog"
                                    class="form-control{{ $errors->has('prog') ? ' is-invalid' : '' }}">

                                        <option value="">Choose Programme</option>
                                    </select>



                                    @if ($errors->has('prog'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('prog') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 offset-1">
                                <div class="form-group row">
                                    <label for="sname" class=" col-form-label">Surname</label>

                                    <input id="sname"
                                        type="text"
                                        class="form-control {{ $errors->has('sname') ? ' is-invalid' : '' }}"
                                        name="sname" placeholder="Type Surname"
                                        value="{{ old('sname') }}"
                                        autocomplete="sname" >

                                    @if ($errors->has('sname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('sname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="mname" class=" col-form-label">Middle Name</label>

                                    <input id="mname"
                                        type="text"
                                        class="form-control{{ $errors->has('mname') ? ' is-invalid' : '' }}"
                                        name="mname" placeholder="Type Middle Name(Optional)"
                                        value="{{ old('mname') }}"
                                        autocomplete="mname" >

                                    @if ($errors->has('mname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-form-label">Email Address</label>

                                    <input id="email"
                                        type="email" placeholder="Type Valid Email Address"
                                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        name="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email" >

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    <label for="amt" class=" col-form-label">Amount</label>

                                    <input id="amt"
                                        type="text"
                                        class="form-control{{ $errors->has('amt') ? ' is-invalid' : '' }}"
                                        name="amt"
                                        value=""
                                        autocomplete="amt" readOnly >


                                </div>





                            </div>
                            <div class="col-12 pt-4">

                                <button class="btn btn-primary btn-block">Submit & Generate RRR</button>

                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
       
        <div class=" col-3 ">
            <div class="text-dark font-weight-bold">
            <span class="fa-stack">
                <i class="far fa-circle fa-stack-2x"></i>
                <strong class="fa-stack-1x fa-stack-text text-info fa-inverse">2</strong>
            </span>Pay with your RRR to the BANK and wait for 24 hours</div>
            <div class="text-dark font-weight-bold align-items-center" align="center" ><br>
                <span class="fa-stack">
                    <i class="far fa-circle fa-stack-2x"></i>
                    <strong class="fa-stack-1x fa-stack-text text-info fa-inverse">3</strong>
                </span>
            </div>
            <div class="card ">
                @if(session('error_1'))
                    <div class="alert alert-danger">
                        {!! session('error_1') !!}
                    </div>
                @endif
                <div d-flex p-3 bg-secondary text-white>
                    <span><button class="btn btn-primary" onclick="myModa()" data-toggle="modal" data-target="#myModal"> Fill Form </button>
                    <button class="btn btn-warning " onclick="myModa2()" data-toggle="modal" data-target="#myModal" style="float:right"> View Form </button></span>
                </div>


            </div>
        </div>

        @endif
    </div>



</div>
@include('inc.modal')
@endsection
