<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\faculty;
use App\programme;
use App\Apply;
use App\Form;
use Intervention\Image\Facades\Image;

class ApplyController extends Controller
{
   public function index()
   {
        //$faculties = new faculty();
       // $faculties = faculty::all()->orderBy('faculty_desc');
        $faculties = DB::table('faculties')->orderBy('faculty_desc')->get()  ;
      //  return view('applys')->with('applys',$applys);
       return view('apply.index')->with('faculties',$faculties);
   }
   public function show( $faculty)
   {
        //$prog = programme::whereIn('faculty_id', $faculty);
       // return $faculty;
       $prog = DB::table('programmes')->where('faculty_id',$faculty)->get();
        return collect([
                'response'=> 'success',
                'prog'=>$prog,
        ]);
        //return $prog;

   }

   public function show2( $prog_id)
   {
        //$prog = programme::whereIn('faculty_id', $faculty);
       // return $faculty;
       $prog = DB::table('programmes')->where('prog_id',$prog_id)->first();
        return $prog->prog_cat;
        //return $prog;

   }

   public function show3( $form_id,$rrr)
   {

     $count = DB::table('applies')->where('appl_id',$form_id)->count();
     if($count==0){ return 'Form Number does not Exist';}

     $count = DB::table('remita_posts')->where('form_id',$form_id)->count();
     if($count==0){ return 'Form Number has not paid . <br> Visit your Bank of Payment';}

     $count = DB::table('remita_posts')->where('form_id',$form_id)->where('rrr',$rrr) ->count();
     if($count==0){ return 'Wrong RRR Number ';}

     $count = DB::table('applies')->where('appl_id',$form_id)->where('rrr',$rrr) ->count();
     if($count==0){
          DB::table('applies')->where('appl_id',$form_id)->update(['rrr' => $rrr,'paid' => 'Y','updated_at' => now()]) ;
          $data = DB::table('applies')->where('appl_id',$form_id)->first();
          //insert into form tab
          DB::table('forms')->insert([
               'form_id'=>$data->appl_id,
               'title' => $data->title,
               'sname' => $data->sname,
               'fname' => $data->fname,
               'mname' => $data->mname,
               'faculty_id' => $data->faculty_id,
               'prog_id' => $data->prog_id,
               'email' => $data->email,
               'created_at' => now(),
               'updated_at' => now()
          ]);

     }
     session(['form_id' => $form_id]);
     return 1;


   }

   public function show4( $form_id)
   {
     $count = DB::table('applies')->where('appl_id',$form_id)->count();
     if($count==0){ return 'Form Number does not Exist';}

     $count = DB::table('forms')->where('form_id',$form_id)->count();
     if($count==0){ return 'Form has not been completed';}

     $count = DB::table('forms')->where('form_id',$form_id)->where('subm','Y')->count();
     if($count==0){ return 'Form has not been submitted. Kindly submit your form';}
     
     //$data = DB::table('forms')->where('form_id',$form_id) ->first();
     
     session(['sform_id' => $form_id]);
     return 1;


   }
   public function store(Request $request)
   {
     $this->validate($request,[
          'title' => 'required',
          'sname' => 'required',
          'fname' => 'required',
          'faculty' => 'required',
          'prog' => 'required',
          'email' => ['required','email'],
          'amt' => 'required',
      ]);
     //$appl_id = DB::table('applies')->max('id');
     $appl_id= DB::table('applies')->insertGetId(
          [
               'title' => $request->input('title'),
               'sname' => $request->input('sname'),
               'fname' => $request->input('fname'),
               'mname' => $request->input('mname'),
               'faculty_id' => $request->input('faculty'),
               'prog_id' => $request->input('prog'),

               'email' => $request->input('email'),
               'amt' => $request->input('amt'),
               'created_at' => now(),
               'updated_at' => now()
          ]
      );
     //++$appl_id;

     DB::table('applies')->where('id',$appl_id)->update(['appl_id' => '1'.date("ymd").$appl_id]) ;
     //'appl_id'=>'1'.date("ymd").$appl_id ,
    // $apply= new apply;

     //save apply
     //$apply->save();

     $formId = DB::table('applies')->where('id', $appl_id)->first();
     //$val=$formId;
     //echo $user->name;
     $str='Your Form Number is <strong>'.$formId->appl_id.'</strong>
      <br>Visit the RRR link to get RRR.
      <br>Use the Form Number as your Payer\'s Name
      ';
     //Redirect
     return redirect('/apply') -> with('success',$str);

   }

   public function viewform()
   {

     $data = DB::table('forms')->where('form_id',session('form_id'))->first();
     if($data->subm == 'Y'){ return redirect('/apply') -> with('error_1','Form cannot be retrieved because it is submitted.');}
     $imagePath = ($data->image) ? $data->image : 'profile/outdLvxnzy5xXK6UnNvzadaB3wHlox5OnD0ddSOw.png';
     $imagePath = '/storage/' . $imagePath;
     //return
     $olevel=(object)[];//display subjects and grades
     for($i=1;$i<=2;$i++)
     {
          
          ${'split'.$i} =explode('^',$data->{'olevel'.$i});
          isset(${'split'.$i}[1]) ? $olevel->{'exam'.$i}=${'split'.$i}[1]: $olevel->{'exam'.$i}='' ;
          isset(${'split'.$i}[2]) ? $olevel->{'examyr'.$i}=${'split'.$i}[2]: $olevel->{'examyr'.$i}='' ;
          isset(${'split'.$i}[3]) ? $olevel->{'candnum'.$i}=${'split'.$i}[3]: $olevel->{'candnum'.$i}='' ;
          isset(${'split'.$i}[4]) ? ${'subj'.$i}=${'split'.$i}[4]: ${'subj'.$i}='' ;
          //$olevel->{'examyr'.$i}=${'split'.$i}[2];
         // $olevel->{'candnum'.$i}=${'split'.$i}[3];
         // ${'subj'.$i}=${'split'.$i}[4];
          $olevel->{'subj'.$i}=array();
          $olevel->{'grad'.$i}=array();
          ${'arrsubj'.$i}=explode('**',${'subj'.$i});
          for($j=0;$j< count(${'arrsubj'.$i});$j++)
          {
               $arr=explode('@@@',${'arrsubj'.$i}[$j]);
               if(isset($arr[0])) $olevel->{'subj'.$i}[$j]=$arr[0];
               if(isset($arr[1]))$olevel->{'grad'.$i}[$j]=$arr[1];
          }
         
          

     }

     $faculty = DB::table('faculties')->where('faculty_id',$data->faculty_id)->first();
     $progcat = DB::table('programmes')->where('prog_id',$data->prog_id)->first();
     $prog = DB::table('programmes')->where('faculty_id',$data->faculty_id)->where('prog_cat',$progcat->prog_cat)->get();
     $subj=DB::table('subjects')->orderBy('subj_desc')->get();
     $grade=['A1','B2','B3','C4','C5','C6','D7','E8','F9'];

     $degrees=DB::table('deg_tabs')->orderBy('degrees')->get();
     return view('apply.form', compact('data','faculty','prog','imagePath','subj','grade','olevel','degrees'));
   }

   public function viewmyform()
   {

     $data = DB::table('forms')->where('form_id',session('sform_id'))->first();
     if($data->subm == 'N'){ return redirect('/apply') -> with('error_1','Form cannot be viewed because it is not submitted.');}
     $imagePath = ($data->image) ? $data->image : 'profile/outdLvxnzy5xXK6UnNvzadaB3wHlox5OnD0ddSOw.png';
     $imagePath = '/storage/' . $imagePath;
     //return
     $olevel=(object)[];//display subjects and grades
     for($i=1;$i<=2;$i++)
     {
          
          ${'split'.$i} =explode('^',$data->{'olevel'.$i});
          isset(${'split'.$i}[1]) ? $olevel->{'exam'.$i}=${'split'.$i}[1]: $olevel->{'exam'.$i}='' ;
          isset(${'split'.$i}[2]) ? $olevel->{'examyr'.$i}=${'split'.$i}[2]: $olevel->{'examyr'.$i}='' ;
          isset(${'split'.$i}[3]) ? $olevel->{'candnum'.$i}=${'split'.$i}[3]: $olevel->{'candnum'.$i}='' ;
          isset(${'split'.$i}[4]) ? ${'subj'.$i}=${'split'.$i}[4]: ${'subj'.$i}='' ;
          //$olevel->{'examyr'.$i}=${'split'.$i}[2];
         // $olevel->{'candnum'.$i}=${'split'.$i}[3];
         // ${'subj'.$i}=${'split'.$i}[4];
          $olevel->{'subj'.$i}=array();
          $olevel->{'grad'.$i}=array();
          ${'arrsubj'.$i}=explode('**',${'subj'.$i});
          for($j=0;$j< count(${'arrsubj'.$i});$j++)
          {
               $arr=explode('@@@',${'arrsubj'.$i}[$j]);
               if(isset($arr[0])) $olevel->{'subj'.$i}[$j]=$arr[0];
               if(isset($arr[1]))$olevel->{'grad'.$i}[$j]=$arr[1];
          }
         
          

     }

     $faculty = DB::table('faculties')->where('faculty_id',$data->faculty_id)->first();
     $progcat = DB::table('programmes')->where('prog_id',$data->prog_id)->first();
     $prog = DB::table('programmes')->where('faculty_id',$data->faculty_id)->where('prog_cat',$progcat->prog_cat)->get();
     $subj=DB::table('subjects')->orderBy('subj_desc')->get();
     $grade=['A1','B2','B3','C4','C5','C6','D7','E8','F9'];

     $degrees=DB::table('deg_tabs')->orderBy('degrees')->get();
     return view('apply.view', compact('data','faculty','prog','progcat','imagePath','subj','grade','olevel','degrees'));
   }

   public function uplimage(Request $request)
   {
     $this->validate($request,[

          'image' => 'required|image',

      ]);

     $imagePath = request('image')->store('appl_passports', 'public');

     $image = Image::make(public_path("storage/{$imagePath}"))->resize(250,null,function ($constraint){
          $constraint->aspectRatio();
     });
     $image->save();
     DB::table('forms')->where('form_id',session('form_id'))->update([
          'image' => $imagePath,

          'updated_at' => now()
     ]);
     return redirect('/apply/form') -> with('saved','Picture Loaded. Kindly remember to submit your form.');
   }

   public function saveform(Request $request)
   {
     $this->validate($request,[

          'prog' => 'required',
          'email' => 'email',
          'phnum' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
          'nokphnum' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
      ]);
     
     for($i=1;$i<=2;$i++)
     {
          ${'exam'.$i}=str_ireplace('^','',$request->input('exam'.$i));
          ${'examyr'.$i}=str_ireplace('^','',$request->input('examyr'.$i));
          ${'candnum'.$i}=str_ireplace('^','',$request->input('candnum'.$i));
          ${'str'.$i}='';$cnt=0;${'arr'.$i} =array();
          for($j=0;$j<9;$j++)
          {
               
               ${'subj'.$i.'_'.$j}=str_ireplace('^','',$request->input('subj'.$i.'_'.$j));
               ${'grad'.$i.'_'.$j}=str_ireplace('^','',$request->input('grad'.$i.'_'.$j));
               if((${'subj'.$i.'_'.$j}=='' && ${'grad'.$i.'_'.$j} <>'') || (${'subj'.$i.'_'.$j}<>'' && ${'grad'.$i.'_'.$j} ==''))
               {
                    return redirect('/apply/form') -> with('error_1','Invalid Subject and Grade Entry.');
               }else if(${'subj'.$i.'_'.$j}<>'' && ${'grad'.$i.'_'.$j} <>'')
               {
                    if(array_search(${'subj'.$i.'_'.$j},${'arr'.$i}) !== false)
                    {
                        // return ${'arr'.$i};
                         return redirect('/apply/form') -> with('error_1',${'subj'.$i.'_'.$j}.' subject appeared more than once in a sitting.');
                    }
                    if($cnt==0){
                         ${'str'.$i}.=${'subj'.$i.'_'.$j}.'@@@'.${'grad'.$i.'_'.$j};
                         
                    }else
                    {
                         ${'str'.$i}.='**'.${'subj'.$i.'_'.$j}.'@@@'.${'grad'.$i.'_'.$j};
                    }
                    ${'arr'.$i}[]=${'subj'.$i.'_'.$j};
                   ++$cnt;
               }
               
          } //return ${'arr'.$i};
          ${'olevel'.$i}='^'.${'exam'.$i}.'^'.${'examyr'.$i}.'^'.${'candnum'.$i}.'^'.${'str'.$i};

     }
     //$olevel_1='';
     //str_ireplace('^','',$str);
     DB::table('forms')->where('form_id',session('form_id'))->update([
          'prog_id' => $request->input('prog'),
          'email' => $request->input('email'),
          'caddress' => $request->input('caddress'),
          'phonenum' => $request->input('phnum'),
          'nokcaddress' => $request->input('nokcaddress'),
          'nokphonenum' => $request->input('nokphnum'),
          'olevel1'=>$olevel1,
          'olevel2'=>$olevel2,
          'other_qual'=> $request->input('taghid'),
          'comments'=> $request->input('comments'),
          'updated_at' => now()
     ]);
     return redirect('/apply/form') -> with('saved','Records Saved. Kindly remember to submit your form.');
   }


   /////////////////////////submit form 

   public function subform(Request $request)
   {
     $this->validate($request,[

          'prog' => 'required',
          'email' => 'email',
          'phnum' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
          'nokphnum' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
          'caddress'=>'required',
          'nokcaddress'=>'required',
      ]);
     
     for($i=1;$i<=2;$i++)
     {
          ${'exam'.$i}=str_ireplace('^','',$request->input('exam'.$i));
          ${'examyr'.$i}=str_ireplace('^','',$request->input('examyr'.$i));
          ${'candnum'.$i}=str_ireplace('^','',$request->input('candnum'.$i));
          ${'str'.$i}='';$cnt=0;${'arr'.$i} =array();
          for($j=0;$j<9;$j++)
          {
               
               ${'subj'.$i.'_'.$j}=str_ireplace('^','',$request->input('subj'.$i.'_'.$j));
               ${'grad'.$i.'_'.$j}=str_ireplace('^','',$request->input('grad'.$i.'_'.$j));
               if((${'subj'.$i.'_'.$j}=='' && ${'grad'.$i.'_'.$j} <>'') || (${'subj'.$i.'_'.$j}<>'' && ${'grad'.$i.'_'.$j} ==''))
               {
                    return redirect('/apply/form') -> with('error_1','Invalid Subject and Grade Entry.');
               }else if(${'subj'.$i.'_'.$j}<>'' && ${'grad'.$i.'_'.$j} <>'')
               {
                    if(array_search(${'subj'.$i.'_'.$j},${'arr'.$i}) !== false)
                    {
                        // return ${'arr'.$i};
                         return redirect('/apply/form') -> with('error_1',${'subj'.$i.'_'.$j}.' subject appeared more than once in a sitting.');
                    }
                    if($cnt==0){
                         ${'str'.$i}.=${'subj'.$i.'_'.$j}.'@@@'.${'grad'.$i.'_'.$j};
                         
                    }else
                    {
                         ${'str'.$i}.='**'.${'subj'.$i.'_'.$j}.'@@@'.${'grad'.$i.'_'.$j};
                    }
                    ${'arr'.$i}[]=${'subj'.$i.'_'.$j};
                   ++$cnt;
               }
               
          } //return ${'arr'.$i};
          if((${'str'.$i}<>'' || $i==1) && (${'exam'.$i}=='' || ${'examyr'.$i}=='' || ${'candnum'.$i}=='' ))
          {
               return redirect('/apply/form') -> with('error_1','Kindly fill all the necessary exam details.');
          }
          if((${'str'.$i}=='') && (${'exam'.$i}<>'' || ${'examyr'.$i}<>'' || ${'candnum'.$i}<>'' ))
          {
               return redirect('/apply/form') -> with('error_1','Kindly fill the subjects and grades.');
          }
          ${'olevel'.$i}='^'.${'exam'.$i}.'^'.${'examyr'.$i}.'^'.${'candnum'.$i}.'^'.${'str'.$i};

     }
     $tab = DB::table('forms')->where('form_id',session('form_id'))->first();
     if($tab->image ==''){
          return redirect('/apply/form') -> with('error_1','Please upload your picture.');
     }


     DB::table('forms')->where('form_id',session('form_id'))->update([
          'prog_id' => $request->input('prog'),
          'email' => $request->input('email'),
          'caddress' => $request->input('caddress'),
          'phonenum' => $request->input('phnum'),
          'nokcaddress' => $request->input('nokcaddress'),
          'nokphonenum' => $request->input('nokphnum'),
          'olevel1'=>$olevel1,
          'olevel2'=>$olevel2,
          'other_qual'=> $request->input('taghid'),
          'comments'=> $request->input('comments'),
          'subm'=>'Y',
          'updated_at' => now()
     ]);
     $formid=session('form_id');
     session()->flush();
     return redirect('/apply') -> with('success2','Form Number <strong>'.$formid.'</strong> successfully saved <br> Visit the site later for your admission status');
   }

}
