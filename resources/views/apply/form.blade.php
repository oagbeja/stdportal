@extends('layouts.app')
@section('content')

<div class="container mt-3 pt-5">
    <p class="float-right">
        <em><a href="/" class=" text-info">Home</a> >
        <a href="/apply" class=" text-info">Apply</a> >
        Form</em>
    </p>
    @if(session('saved'))
        <div class="alert alert-success  float-right col-5">
            {!! session('saved') !!}
        </div>
    @endif
    @if(session('error_1'))
        <div class="alert alert-danger  float-right col-5">
            {!! session('error_1') !!}
        </div>
    @endif
  <h2>Form Number: <span class="text-info">{!! session('form_id') !!}</span></h2>
    
  <br>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="tab" href="#home">Bio Data</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu1">Qualifications</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="tab" href="#menu2">Others</a>
    </li>
  </ul>
  <div id="loader" style="display:none"></div>
  <!-- Tab panes -->
    <form  id="frm" enctype="multipart/form-data" method="post">
    @csrf

        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
            <!--<p class="lead">BIO DATA</p>-->
                <div class="card">
                    <div class="row ">
                        <div class="col-4 offset-1">

                            <div class="pt-4 row ">
                                <div class="col-6 pl-0 " style="float:left"><label  class="col-form-label font-weight-bold">Title</label> </div>
                                <div class="col-6 pl-0 col-form-label" style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->title !!}</div>
                            </div>
                            <div class=" row ">
                                <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Surname</label> </div>
                                <div class="col-6 pl-0" style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->sname !!}</div>
                            </div>
                            <div class=" row ">
                                <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">First Name</label> </div>
                                <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->fname !!}</div>
                            </div>
                            <div class=" row ">
                                <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Middle Name</label> </div>
                                <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $data->mname !!}</div>
                            </div>
                            <div class=" row ">
                                <div class="col-6 pl-0" style="float:left"><label  class=" font-weight-bold">Faculty</label> </div>
                                <div class="col-6 pl-0 " style="float:left">&nbsp;&nbsp;&nbsp;&nbsp; {!! $faculty->faculty_desc !!}</div>
                            </div>

                            <div class="form-group row" id="prog_show">
                                <label for="prog" class=" col-form-label">Programme</label>

                                <select name="prog" id="prog"
                                class="form-control{{ $errors->has('prog') ? ' is-invalid' : '' }}">

                                    <option value="">Choose Programme</option>

                                        @foreach($prog as $progr)
                                            <option value="{{$progr->prog_id}}"
                                                 @if ($progr->prog_id == $data->prog_id)
                                                    selected
                                                 @endif
                                            >
                                                 {{$progr->prog_desc}}
                                            </option>
                                        @endforeach
                                </select>



                                @if ($errors->has('prog'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('prog') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-form-label">Email Address</label>

                                <input id="email"
                                    type="email" placeholder="Type Valid Email Address"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email"
                                    value="{{ old('email')  ??  $data->email }} "
                                    autocomplete="email" >

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="caddress" class=" col-form-label">Contact Address</label>
                                <textarea name="caddress" id="caddress" class="form-control {{ $errors->has('caddress') ? ' is-invalid' : '' }}"  placeholder="Type Your Address" >{{ old('caddress') ?? $data->caddress }}</textarea>



                                @if ($errors->has('caddress'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('caddress') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-4 offset-1">

                            <div class="form-group row pt-3" >
                                <div class="float-right" >
                                    <img src="{!! $imagePath !!}"  alt="No Image"  style="max-height:150px"  class="float-right rounded  img-thumbnail  w-50">

                                </div>

                            </div>
                            <div class="offset-5 text-info" >
                                <input type="file" class="form-control-file text-info " onchange="uplimg()" id="image" name="image">

                                @if ($errors->has('image'))

                                    <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="phnum" class=" col-form-label">Phone Number</label>

                                <input id="phnum"
                                    type="tel"
                                    class="form-control {{ $errors->has('phnum') ? ' is-invalid' : '' }}"
                                    name="phnum" placeholder="Type Your Current Number"
                                    value="{{ old('phnum') ?? $data->phonenum }}"
                                    autocomplete="phnum" >

                                @if ($errors->has('phnum'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phnum') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="nokcaddress" class=" ">Next Of Kin Contact Address</label>
                                <textarea name="nokcaddress" id="nokcaddress" class="form-control {{ $errors->has('nokcaddress') ? ' is-invalid' : '' }}"  placeholder="Type Your NOK Address" >{{ old('nokcaddress') ?? $data->nokcaddress }}</textarea>


                                @if ($errors->has('nokcaddress'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nokcaddress') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group row">
                                <label for="nokphnum" class=" ">Next OF Kin Phone Number</label>

                                <input id="nokphnum"
                                    type="tel"
                                    class="form-control {{ $errors->has('nokphnum') ? ' is-invalid' : '' }}"
                                    name="nokphnum" placeholder="Type Your NOK Current Number"
                                    value="{{ old('nokphnum') ?? $data->nokphonenum }}"
                                    autocomplete="nokphnum" >

                                @if ($errors->has('nokphnum'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nokphnum') }}</strong>
                                    </span>
                                @endif
                            </div>


                        </div>

                    </div>
                </div>
            </div>
            <div id="menu1" class="container tab-pane fade "><br>
                <h3>O Level </h3>
                <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                <div class="row pt-2  pb-2 ">
                    <div class="card col-6 pt-2 pb-1 ">
                        <p class="lead text-info">1<sup>st</sup> Sitting</p>
                        <div class="row pb-2">
                        <div class= "col-10 ">
                         <div class="d-flex">
                         <label for="exam1" class="col-6 ">Exam Name</label>

                         <input id="exam1"
                                type="text"
                                class="form-control  {{ $errors->has('exam1') ? ' is-invalid' : '' }}"
                                name="exam1" placeholder="Exam Name"
                                value="{{ old('exam1') ?? $olevel->exam1}}"
                                autocomplete="exam1" >

                            @if ($errors->has('exam1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('exam1') }}</strong>
                                </span>
                            @endif
                         </div>
                         <div class="d-flex">
                         <label for="examyr1" class="col-6 ">Exam Year</label>
                         <input id="examyr1"
                                type="text"
                                class="form-control {{ $errors->has('examyr1') ? ' is-invalid' : '' }}"
                                name="examyr1" placeholder="Exam Year"
                                value="{{ old('examyr1') ?? $olevel->examyr1 }}"
                                autocomplete="examyr1" >

                            @if ($errors->has('examyr1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('examyr1') }}</strong>
                                </span>
                            @endif
                          </div>
                         <div class="d-flex">

                            <label for="candnum1" class="col-6 ">Candidate No.</label>
                            <input id="candnum1"
                                type="text"
                                class="form-control pt-1  {{ $errors->has('candnum1') ? ' is-invalid' : '' }}"
                                name="candnum1" placeholder="Candidate No."
                                value="{{ old('candnum1') ?? $olevel->candnum1 }}"
                                autocomplete="candnum1" >

                            @if ($errors->has('candnum1'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('candnum1') }}</strong>
                                </span>
                            @endif
                        </div>
                       
                        </div>
                        
                        </div>
                        <hr>
                        @for($i=0; $i<9; $i++)

                            <div class=" row " >
                               
                                 <select name="subj1_{{$i}}" id="subj1_{{$i}}"
                                   
                                   class="form-control col-6 offset-1 {{ $errors->has('subj1_$i') ? ' is-invalid' : '' }}">
   
                                       <option class="text-warning" value="">Choose Subject</option>
   
                                           @foreach($subj as $subjr)
                                               <option value="{{$subjr->subj_desc}}"
                                               @if(isset($olevel->subj1[$i])) @if ($subjr->subj_desc == $olevel->subj1[$i])
                                                       selected
                                                       @endif @endif
                                               >
                                                       {{$subjr->subj_desc}}
                                               </option>
                                           @endforeach
                                   </select>
                               
                                
                                <select name="grad1_{{$i}}" id="grad1_{{$i}}"
                                class="form-control offset-1 col-3  ">

                                    <option value=""></option>

                                        @for($j=0; $j<count($grade); $j++)
                                            <option value="{{$grade[$j]}}"
                                                  @if(isset($olevel->grad1[$i]))  @if ($grade[$j] == $olevel->grad1[$i])
                                                    selected
                                                    @endif @endif
                                            >
                                                    {{$grade[$j]}}
                                            </option>
                                        @endfor
                                </select>



                            </div>
                        @endfor
                    </div>
                    <div class="card col-6 pt-2 pb-1 ">
                        <p class="lead text-info">2<sup>nd</sup> Sitting</p>
                        <div class="row pb-2">
                        <div class= "col-10 ">
                         <div class="d-flex">
                         <label for="exam2" class="col-6 ">Exam Name</label>

                         <input id="exam2"
                                type="text"
                                class="form-control  {{ $errors->has('exam2') ? ' is-invalid' : '' }}"
                                name="exam2" placeholder="Exam Name"
                                value="{{ old('exam2') ?? $olevel->exam2 }}"
                                autocomplete="exam2" >

                            @if ($errors->has('exam2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('exam2') }}</strong>
                                </span>
                            @endif
                         </div>
                         <div class="d-flex">
                         <label for="examyr2" class="col-6 ">Exam Year</label>
                         <input id="examyr2"
                                type="text"
                                class="form-control {{ $errors->has('examyr2') ? ' is-invalid' : '' }}"
                                name="examyr2" placeholder="Exam Year"
                                value="{{ old('examyr2') ?? $olevel->examyr2 }}"
                                autocomplete="examyr2" >

                            @if ($errors->has('examyr2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('examyr2') }}</strong>
                                </span>
                            @endif
                          </div>
                         <div class="d-flex">

                            <label for="candnum2" class="col-6 ">Candidate No.</label>
                            <input id="candnum2"
                                type="text"
                                class="form-control pt-1  {{ $errors->has('candnum2') ? ' is-invalid' : '' }}"
                                name="candnum2" placeholder="Candidate No."
                                value="{{ old('candnum2') ?? $olevel->candnum2 }}"
                                autocomplete="candnum2" >

                            @if ($errors->has('candnum2'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('candnum2') }}</strong>
                                </span>
                            @endif
                        </div>
                        </div>
                        </div>
                        <hr>
                        @for($i=0; $i<9; $i++)

                            <div class="  row" >


                               
                                 <select name="subj2_{{$i}}" id="subj2_{{$i}}"
                                   
                                   class="form-control col-6 offset-1 {{ $errors->has('subj2_$i') ? ' is-invalid' : '' }}">
   
                                       <option  value="">Choose Subject</option>
   
                                            @foreach($subj as $subjr)
                                               <option value="{{$subjr->subj_desc}}"
                                               @if(isset($olevel->subj2[$i])) @if ($subjr->subj_desc == $olevel->subj2[$i])
                                                       selected
                                                       @endif @endif
                                               >
                                                       {{$subjr->subj_desc}}
                                               </option>
                                           @endforeach
                                   </select>
                               
                                <select name="grad2_{{$i}}" id="grad2_{{$i}}"
                                class="form-control offset-1 col-3  ">

                                    <option value=""></option>

                                        @for($j=0; $j<count($grade); $j++)
                                            <option value="{{$grade[$j]}}"
                                                  @if(isset($olevel->grad2[$i]))  @if ($grade[$j] == $olevel->grad2[$i])
                                                    selected
                                                    @endif @endif
                                            >
                                                    {{$grade[$j]}}
                                            </option>
                                        @endfor
                                </select>



                            </div>
                        @endfor
                    </div>
                </div>
                <h3>Degrees </h3>
                <div class="d-flex">
                    <select name="degrees" id="degrees" onchange="find_deg()"
                                    
                        class="form-control col-4 offset-1 " >
                        <option value="">Choose Previous Degrees</option>
                            @foreach($degrees as $degree)
                                <option value="{{$degree->degrees}}">
                            
                                        {{$degree->degrees}}
                                </option>
                            @endforeach
                            <option value="Others">Others</option>
                    </select>&nbsp;
                    <button type="button" onclick="add_deg()" class="btn btn-primary  btn-sm col-1 ">Add</button>&nbsp;
                    <button type="button" onclick="rem_deg()" class="btn btn-danger  btn-sm col-1 ">Remove</button>
                    <input id="inp_hid" name="inp_hid" style="display:none" placeholder="Type In your Degree" class="form-control col-4 offset-1" type="text">
                </div>
                
                
                
                <br>
                <div id="tagDegree" class="card col-6 offset-1 bg-dark text-white">
                    {{$data->other_qual}}
                </div>
                
                <input id="taghid" name="taghid" value="{{$data->other_qual}}" type="hidden">
            </div>
            <div id="menu2" class="container tab-pane fade"><br>
                <h3>Other Information</h3>
                <textarea name="comments" id="comments" class="form-control "  placeholder="More Information You want us to Know?" >{{ old('comments') ?? $data->comments }}</textarea>
                <br>
                <h3>Acknowlegement</h3>
                <div class="d-flex">
                    
                    <input type="checkbox" id="check" class="form-control col-1 " onclick="clicksub()" title="click to agree" >
                    I, {!! $data->sname !!}, {!! $data->fname !!} {!! $data->mname !!} hereby acknowledge and 
                    give accurate information of myself and should not be regarded and may be prosecuted if I have supplied false information.<br>Thank you. 
                </div>
            </div>
        </div>

        <div class="col-12 pt-2 pb-5">
            <button class="btn btn-warning   float-left" type="button" onclick="savfrm()" >SAVE</button>

            <button class="btn btn-primary disabled float-right"  data-toggle="" data-target="#myModal" id="sub" type="button" onclick="subfrm()" >Submit</button>

        </div>
    </form>
</div>
@include('inc.modal')
@endsection
