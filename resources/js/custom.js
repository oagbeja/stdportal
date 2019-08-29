chgprog =() => {
   // alert(document.querySelector('#faculty').value);
    axios.post('/prog/' + document.querySelector('#faculty').value)
    .then(response => {
       // this.status = ! this.status;
       let str= '<label for="prog" class=" col-form-label">Programme</label>';
       str+='<select name="prog" id="prog" onchange="chgamt()" class="form-control {{ $errors->has(';
       str+="'prog') ? ' is-invalid' : '' }}";
       str+='"> <option value="">Choose Programme</option>';
       let mydata= response.data.prog;
       for(i=0;i< mydata.length ; i++)
       {
        str+=' <option value="'+ mydata[i].prog_id +'">'+ mydata[i].prog_desc +'</option>';
       }
       
       str+='</select>'
        document.querySelector('#prog_show').innerHTML= str ;
        console.log(response.data);
        
    })
    .catch(errors => {
        if (errors.response.status == 401) {
            window.location = '/login';
        }
    });
}

chgamt =() => {
    // alert(document.querySelector('#faculty').value);
     axios.post('/progamt/' + document.querySelector('#prog').value)
     .then(response => {
        // this.status = ! this.status;
        if(response.data=='U') 
        {
            document.querySelector('#amt').value="5000";
        }else{
            document.querySelector('#amt').value="7500";
        }
         console.log(response.data);
         
     })
     .catch(errors => {
         if (errors.response.status == 401) {
             window.location = '/login';
         }
     });
}
myModa = () =>{
    document.querySelector('.modal-title').innerHTML="Enter Form Details";
    let str='<div class=""  id="report" ></div>';
    str+='<input id="formId" type="text" class="form-control"';
    
    str+='name="formId" placeholder="Type Form Number"  value=""';
    str+='" autocomplete="formId" ><br>';

    str+='<input id="rrr" type="text" class="form-control"';
    
    str+='name="rrr" placeholder="Type RRR"  value=""';
    str+='" autocomplete="rrr" ><br>';

    str+='<button class="btn btn-primary btn-block" onclick="subm()" type="button"> Submit </button> ';
    str+='';
    document.querySelector('.modal-body').innerHTML= str;

   
   
}

myModa2 = () =>{
    document.querySelector('.modal-title').innerHTML="Enter Form Details";
    let str='<div class=""  id="report" ></div>';
    str+='<input id="formId" type="text" class="form-control"';
    
    str+='name="formId" placeholder="Type Form Number"  value=""';
    str+='" autocomplete="formId" ><br>';

    str+='<button class="btn btn-primary btn-block" onclick="subm2()" type="button"> View </button> ';
    str+='';
    document.querySelector('.modal-body').innerHTML= str;

   
   
}


subm = ()=>{
    let chk='';document.querySelector('#report').innerHTML= '';
    //////////////////////////
    document.querySelector('#report').classList.remove('alert','alert-success');
    
    ///////////////////


    if(document.querySelector('#formId').value == ''  )
    {
        document.querySelector('#report').classList.add('alert','alert-danger');
        document.querySelector('#report').innerHTML= 'Enter Values of  Form Number<br>';
        //document.querySelector('#report').style.display="show";
        chk=1;
    }
    if( document.querySelector('#rrr').value == '' )
    {
        document.querySelector('#report').classList.add('alert','alert-danger');
        document.querySelector('#report').innerHTML+= 'Enter Values of RRR <br>';
       // document.querySelector('#report').style.display="show";
       chk=1;
    }
    if(chk !== 1)
    {
        let formId=document.querySelector('#formId').value; 
        let rrr= document.querySelector('#rrr').value;
        formId=formId.replace("/","");
        rrr=rrr.replace("/","");
        axios.post('/form_rrr/' + formId + '/'+ rrr )
        .then(response => {
            // this.status = ! this.status; 
            console.log(response.data);

            if(response.data==1){
                document.querySelector('#report').classList.remove('alert','alert-danger');
                document.querySelector('#report').classList.add('alert','alert-success');
                document.querySelector('#report').innerHTML='Successful.<br>Waiting to load the form...';
                window.location = '/apply/form';
            }else{
                document.querySelector('#report').classList.add('alert','alert-danger');
                document.querySelector('#report').innerHTML=response.data;
            }
            
           
            
        })
        .catch(errors => {
            if (errors.response.status == 401) {
               // window.location = '/login';
            }
        });
    }
}

///////////////view form
subm2 = ()=>{
    let chk='';document.querySelector('#report').innerHTML= '';
    //////////////////////////
    document.querySelector('#report').classList.remove('alert','alert-success');
  
    if(document.querySelector('#formId').value == ''  )
    {
        document.querySelector('#report').classList.add('alert','alert-danger');
        document.querySelector('#report').innerHTML= 'Enter Values of  Form Number<br>';
        //document.querySelector('#report').style.display="show";
        chk=1;
    }
    
    if(chk !== 1)
    {
        let formId=document.querySelector('#formId').value; 
        formId=formId.replace("/","");
        axios.post('/form_view/' + formId )
        .then(response => {
            // this.status = ! this.status; 
            console.log(response.data);

            if(response.data==1){
                document.querySelector('#report').classList.remove('alert','alert-danger');
                document.querySelector('#report').classList.add('alert','alert-success');
                document.querySelector('#report').innerHTML='Successful.<br>Waiting to load the form...';
                window.location = '/apply/view';
            }else{
                document.querySelector('#report').classList.add('alert','alert-danger');
                document.querySelector('#report').innerHTML=response.data;
            }
            
        })
        .catch(errors => {
            if (errors.response.status == 401) {
               // window.location = '/login';
            }
        });
    }
}

savfrm=()=>{
    document.querySelector('#loader').style.display='block';
    document.querySelector('#frm').style.opacity='0.5';
    document.querySelector('#frm').action='/saveform';
    document.querySelector('#frm').submit();
}

uplimg=()=>{
    document.querySelector('#loader').style.display='block';
    document.querySelector('#frm').style.opacity='0.5';
    document.querySelector('#frm').action='/uplimg';
    document.querySelector('#frm').submit();
   
}

find_deg=()=>{
    if(document.querySelector('#degrees').value=='Others')
    {
        document.querySelector('#inp_hid').style.display='block';
    }else
    {
        document.querySelector('#inp_hid').style.display='none';
    }
}

add_deg=()=>{
    let str=srch='';
    if(document.querySelector('#degrees').value !=='')
    {
        if(document.querySelector('#degrees').value=='Others')
        {
            srch= document.querySelector('#tagDegree').innerHTML.toLowerCase().search(document.querySelector('#inp_hid').value.toLowerCase());
            if(srch== -1 )str+=document.querySelector('#inp_hid').value;
        } else
        {
            srch= document.querySelector('#tagDegree').innerHTML.search(document.querySelector('#degrees').value);
            if(srch== -1 )str+=document.querySelector('#degrees').value;
        }
        if(str!=='')
        {
            if(document.querySelector('#tagDegree').innerHTML==''  )
            {
                document.querySelector('#tagDegree').innerHTML+=str;
                document.querySelector('#taghid').value+=str;
            }else
            {
                document.querySelector('#tagDegree').innerHTML+=','+str;
                document.querySelector('#taghid').value+=','+str;
            }
        }
        
        
    }
}

rem_deg=()=>{
    document.querySelector('#tagDegree').innerHTML='';
    document.querySelector('#taghid').value='';
}

clicksub=()=>{
    if(document.querySelector('#check').checked== true)
    {
        document.querySelector('#sub').classList.remove('disabled');
        document.querySelector('#sub').dataset.toggle="modal";
    }else{
        document.querySelector('#sub').classList.add('disabled');
        document.querySelector('#sub').dataset.toggle="";
    }
}

subfrm=()=>{
    document.querySelector('.modal-title').innerHTML="Notice";
    let str='Do you really want to submit? If you submit you will not be able to edit the form again.<br>Click on <strong>YES</strong> to submit, <strong>NO</strong> to go back<br> Thank you';
    document.querySelector('.modal-body').innerHTML= str;
    let str1='<button type="button" class="btn btn-success " onclick="submform()" >YES</button>' ; 
    str1+='<button type="button" class="btn btn-danger " data-dismiss="modal">NO</button>';
    
    document.querySelector('.modal-footer').innerHTML= str1;
}

submform=()=>{
    document.querySelector('#loader').style.display='block';
    document.querySelector('#frm').style.opacity='0.5';
    document.querySelector('#frm').action='/subform';
    document.querySelector('#frm').submit();
}

