<?php include 'sidebar.php';

if(isset($_GET['did'])){
    $sql =mysqli_query($con,"DELETE FROM `service` WHERE `id`='".trim($_GET['did'])."'");
if($sql>0){echo "<script>window.open('service?success','_self')</script>";
}else{echo "<script>alert('Server Busy');window.open('service?failed','_self')</script>";
}   
}

if(isset($_POST['submit'])){
$categorya=validate($_POST['category']);
$namea=validate($_POST['name']);
$servicecosta=validate($_POST['servicecost']);
$cashback=validate($_POST['cashback']);
$advancea=validate($_POST['advance']);
$advancepercentagea=validate($_POST['advancepercentage']);
$serviceduedaysa=validate($_POST['serviceduedays']);
$paymentduedaysa=validate($_POST['paymentduedays']);
$servicetypea=validate($_POST['servicetype']);
   if( isset($_FILES['pic']["name"]) && isset($_FILES['pic']["tmp_name"]) )
        {
           $pic = array();
            $pic = $_FILES['pic']["name"];
            $pic = explode(' ', $pic);
             $pic = array_values(array_filter($pic));

           $pic_temp = array();
             $pic_temp = $_FILES['pic']["tmp_name"];
              $pic_temp = explode(' ', $pic_temp);
            $pic_temp = array_values(array_filter($pic_temp));
$z=$_FILES['pic']["name"];
             for($i=0;$i<count($pic);$i++)
            {
                $my_ext1 = pathinfo( $pic[$i], PATHINFO_EXTENSION );
            if( $my_ext1=='jpg' || $my_ext1=='png' || $my_ext1=='jpeg' || $my_ext1=='gif' ) {
                $final_name1 = $z;//.'.'.$my_ext1;
                   move_uploaded_file($pic_temp[$i],"../images/".$final_name1);
   
             }
            }

             if(isset($final_name1)) {
             $photo = $final_name1;        
            }else{$photo ='';}      
         
        }
//Incorrect double value: '' for column `efillings`.`service`.`duepay` at row 1
$sql =mysqli_query($con,"INSERT INTO `service`(`catid`, `name`, `cost`, `cashback`,`advrequired`, `advper`, `duedays`, `duepay`, `type`, `pic`) VALUES ('".$categorya."','".$namea."','".$servicecosta."','".$cashback."','".$advancea."','".$advancepercentagea."','".$serviceduedaysa."','".$paymentduedaysa."','".$servicetypea."','".$photo."')")or die(mysqli_error($con));
$lid=mysqli_insert_id($con);
if (isset($_POST['documents'])) {
  
foreach ($_POST['documents'] as $key => $value) {


  $sql=mysqli_query($con,"INSERT INTO `servicedoc`(`serviceid`, `document`) VALUES ('$lid','$value')");
}
}

if($sql>0){echo "<script>window.open('service?success','_self')</script>";
}else{echo "<script>alert('Server Busy');window.open('service?failed','_self')</script>";
}       
} 


// under dev
//print_r($_POST['multi_question']);



// under dev
//add field ends
// remove
//not is use starts
 if(isset($_POST['update'])){
 $categorya=validate($_POST['category']);
 $namea=validate($_POST['name']);
 $servicecosta=validate($_POST['servicecost']);
 $advancea=validate($_POST['advance']);
 $advancepercentagea=validate($_POST['advancepercentage']);
 $serviceduedaysa=validate($_POST['serviceduedays']);
 $paymentduedaysa=validate($_POST['paymentduedays']);
 $servicetypea=validate($_POST['servicetype']);
 $servicedetail = validate($_POST['servicedetail']);
 if(!empty($_POST['category'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `catid`='".$categorya."' WHERE `id`='".trim($_GET['edit'])."' ");
 }if(!empty($_POST['name'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `name`='".$namea."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['servicecost'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `cost`='".$servicecosta."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['advance'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `advrequired`='".$advancea."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['advancepercentage'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `advper`='".$advancepercentagea."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['serviceduedays'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `duedays`='".$serviceduedaysa."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['paymentduedays'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `duepay`='".$paymentduedaysa."' WHERE `id`='".trim($_GET['edit'])."'");
 }if(!empty($_POST['servicetype'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `type`='".$servicetypea."' WHERE `id`='".trim($_GET['edit'])."'");
 }

 

    if( isset($_FILES['pic']["name"]) && isset($_FILES['pic']["tmp_name"]) )
         {

           if($_FILES['pic']['size']>0){
             move_uploaded_file($_FILES['pic']['tmp_name'],"../images/".$_FILES['pic']['name'].time());
                         $sql =mysqli_query($con,"UPDATE `service` SET `pic`='".$_FILES['pic']['name'].time()."' WHERE `id`='".trim($_GET['edit'])."'");

        }}

// // echo 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssss';print_r($_POST['servicedetail']);
 if(!empty($_POST['servicedetail'])) {
 $sql =mysqli_query($con,"UPDATE `service` SET `sdetail`='".$servicedetail."' WHERE `id`='".trim($_GET['edit'])."'");
 }

// question
 if(!empty($_POST['multi_question'])){ //print_r($_POST['multi_question']);
$service_id=validate(trim($_GET['edit']));

$fqq = mysqli_query($con,'SELECT * FROM form_question WHERE service_id = "'.trim($_GET['edit']).'"');
$fqen= mysqli_num_rows($fqq);
if($fqen>0){// if question already exist
while($fqr = mysqli_fetch_array($fqq)){
  $fqdata[]=$fqr;}
$fqnw=count($_POST['multi_question'])-count($fqdata);
//echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';echo $fqnw;
   //print_r($fqdata); echo count($_POST['multi_question']);
   if($fqnw==0){//echo 'new entries query, insert or update';
   $qid=0;
   foreach ($_POST['multi_question'] as $key => $value) {
    // print_r($fqdata[0]['q_list_id']);//
    //echo $value;
$certi = mysqli_query($con,'UPDATE `form_question` SET `question`="'.$value.'" WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$qid]['q_list_id'].'"') or die(mysqli_error());
  
  $qid++; }

//cat_id a well
 }elseif($fqnw<0){
//echo 'less entries query, delete and update';
   $qid=0;
  
 //echo count($_POST['multi_question']);
 for ($i=0; $i < count($_POST['multi_question']) ; $i++) { 
    if($i<count($fqdata)-count($_POST['multi_question'])){
$d_less =  mysqli_query($con, ' DELETE FROM  form_question WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$i]['q_list_id'].'" ');
    }
   # code...
 }
 echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';echo count($fqdata)-count($_POST['multi_question']);
  for($j=0; $j<count($_POST['multi_question']); $j++){
    
    $certi = mysqli_query($con,'UPDATE `form_question` SET `question`="'.$_POST['multi_question'][$j].'" WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$i]['q_list_id'].'"') or die(mysqli_error());
  }
   


   //$d_less =  mysqli_query($con, ' DELETE FROM  form_question WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$qid]['q_list_id'].'" ');

   // $certi = mysqli_query($con,'UPDATE `form_question` SET `question`="'.$value.'" WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$qid]['q_list_id'].'"') or die(mysqli_error());

// delete query and update
 }elseif($fqnw>0){
//echo 'udate and insert';
$category_id=validate($_POST['category']);
echo '>0..........................................................................................'; echo count($_POST['multi_question'])-count($fqdata);

$to_up = count($fqdata);
for ($i=0; $i <count($_POST['multi_question']) ; $i++) {

  if($i<$to_up){
   
    $certi = mysqli_query($con,'UPDATE `form_question` SET `question`="'.$_POST['multi_question'][$i].'" WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$i]['q_list_id'].'"') or die(mysqli_error());
  }else{
//$i--;
  //  echo 'insert .....................................'; echo $i=$i+1;
    $in_greater_question = mysqli_query($con, 'INSERT INTO form_question (question, cat_id, service_id)VALUES("'.$_POST['multi_question'][$i].'","'.$category_id.'", "'.$service_id.'")');
  }
  # code...
}
//$certi = mysqli_query($con,'UPDATE `form_question` SET `question`="'.$value.'" WHERE service_id = "'.trim($_GET['edit']).'" AND q_list_id="'.$fqdata[$i]['q_list_id'].'"') or die(mysqli_error());


//$in_greater_question = mysqli_query($con, 'INSERT INTO form_question (question, cat_id, service_id)VALUES("'.$question.'","'.$category_id.'", "'.$service_id.'")');
 }

}
else{
  //if no question exist then insert only
 //echo 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'; echo '';
 $category_id=validate($_POST['category']);
//print_r($_POST);
  foreach ($_POST['multi_question'] as $key => $value) {
  $question=addslashes(validate($value));
 // echo $question;  # code...
  $in_question = mysqli_query($con, 'INSERT INTO form_question (question, cat_id, service_id)VALUES("'.$question.'","'.$category_id.'", "'.$service_id.'")');// cat_id as well
}}
}else{
$fqq = mysqli_query($con,'SELECT * FROM form_question WHERE service_id = "'.trim($_GET['edit']).'"');
while($fqr = mysqli_fetch_array($fqq)){$fqdata[]=$fqr;}
//$fqnw=count($_POST['multi_question'])-count($fqdata);
if(!isset($_POST['multi_question'])){
$d =  mysqli_query($con, ' DELETE FROM  form_question WHERE service_id = "'.trim($_GET['edit']).'"');
}

//echo $fqnw;
///echo 'multi_question multi_question multi_question multi_question multi_question multi_question multi_question';
}


 // question
 $lid=mysqli_insert_id($con);
 if($sql>0){//echo "<script>window.open('service.php?success','_self')</script>";
 }else{echo "<script>alert('Server Busy');window.open('service?failed','_self')</script>";
 }       
 }
// remove

//not in use ends 

if(isset($_POST['docupdate'])){
foreach ($_POST['documents'] as $key => $value) {

  $docq = mysqli_query($con, 'SELECT name, type, fieldorfile FROM documentlist WHERE id ="'.$value.'"');
$doc=mysqli_fetch_array($docq);
   $check=mysqli_query($con,"SELECT `id` FROM `servicedoc` WHERE `document`= '".$doc["name"]."' AND serviceid ='".trim($_GET['docsr'])."' ");
 if(empty(mysqli_num_rows($check))){
  $sql=mysqli_query($con,"INSERT INTO `servicedoc`(`serviceid`, `document`, `fieldorfile`, `type`) VALUES ('".trim($_GET['docsr'])."','".$doc["name"]."','".$doc["fieldorfile"]."','".$doc["type"]."')");
 }else{
   echo "<script>window.open('service?docsr=".trim($_GET['docsr'])."&duplicate','_self')</script>";
   exit();
 }
}

if($sql>0){echo "<meta http-equiv=refresh content=0/>";
}else{echo "<script>alert('Server Busy');window.open('service?failed','_self')</script>";
}       
} 

if(isset($_GET['serdel'])){
$sql=mysqli_query($con,"DELETE FROM `servicedoc` WHERE `document`='".trim($_GET['serdel'])."'");


if($sql>0){echo "<meta http-equiv=refresh content=0/>";
}else{echo "<script>alert('Server Busy');window.open('service?failed','_self')</script>";
}       
} 


?> 

<!-- question -->
  <style>
    body {
      display: flex;
      flex-direction: column;
      margin-top: 1%;
      justify-content: center;
      align-items: center;
    }

    #rowAdder {
      margin-left: 17px;
    }


  </style>
<!-- question -->
<div class="content-wrapper">
    <section class="content-header">
      <h1><small>Manage Service</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Service</li>
      </ol>
    </section>
    <section class="content">
            <a href="service"><< Back</a>
            <?php if(isset($_GET['add'])){
           ?>
            <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="color:#000;">Add Service</h3>
            </div>

            <div class="box-body">
           
            <form action="#" method="post" enctype="multipart/form-data">
            <div class="row" style="margin-top: 20px; margin-left: 5px;margin-right: 5px">
               <div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label>Service Category :<span style="color:red"></span></label>
                        <select class="form-control" name="category" required="required">
                          <?php $service=mysqli_query($con,"SELECT `id`, `cast` FROM `cat` ORDER BY `cast` ASC");while($runservice=mysqli_fetch_array($service)){?>
                            <option value="<?php echo $runservice['id']; ?>"><?php echo ucwords($runservice['cast']); ?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>
            <div class=col-sm-6>
                    <div class="form-group mb-10">
                        <label> Service Name<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="name" maxlength="225" required placeholder="Enter Here" />
                    </div>
                </div>
                <div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label> Service Cost<span style="color:red">*</span></label>
                        <input type="text" pattern="[0-9]+" class="form-control" name="servicecost" maxlength="10" required placeholder="Enter Here" />
                    </div>
                      <div class="form-group mb-10">
                        <label>Distribution Amt<span style="color:red">*</span></label>
                        <input type="text" pattern="[0-9]+" class="form-control" name="cashback" maxlength="10" required placeholder="Enter Here" />
                    </div>
                </div>
                <div class=col-sm-5>
                    <div class="form-group mb-10">
                        <label> Advance Required </label>
                       <select class="form-control" name="advance">
<option value="yes">Yes</option>
<option value="no">No</option></select>
                    </div>
                </div>
               
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Advance Percentage <small>(Fill Number only)</small></label>
                        <input type="text" pattern="[0-9]+" class="form-control" name="advancepercentage" placeholder="Enter Here"/>
                    </div>
                </div>
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Service Due Days (Fill Number only)</label>
                        <input type="text" pattern="[0-9]+" class="form-control" name="serviceduedays" placeholder="Enter Here" />
                    </div>
                </div>
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Payment Due Days (Fill Number only)</label>
                        <input type="text" pattern="[0-9]+" class="form-control" name="paymentduedays" placeholder="Enter Here" />
                    </div>
                </div><div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label>Image</label>
                       
                       <input type="file" name="pic">
                    </div>
                </div>
<div class=col-sm-12></div>
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Service Type</label>
                <select class="form-control" name="servicetype">
<option value="onetime">One Time</option>
<option value="recurrent">Recurrent</option>
</select>
                    </div>
                </div>
                <div class=col-sm-8>
                    <div class="form-group mb-10">
                        <label>Required Documents:<span style="color:red"></span></label>
    <select class="form-control select2" multiple="multiple" data-placeholder="Select Documents"
                        style="width: 100%;" name="documents[]" id="documentlist"> 
<?php
$dcs=mysqli_query($con,"SELECT `name`, `type`FROM `documentlist` ORDER BY `name` ASC");while($doctsrun=mysqli_fetch_array($dcs)){?>
<option value="<?php echo ucwords($doctsrun['name']); ?>"><?php echo ucwords($doctsrun['name']); //echo ucwords($doctsrun['type']);?></option>
<?php }?></select>




</div>
                    <div id="result"></div>
                </div>

              </div>
                  
              <!-- Dynamic Questions From Admin -->

                <strong> Add Service Related Questions <button id="rowwAdder" type="button" class="btn btn-dark">
                  <span class="bi bi-plus-square-dotted">
                    </span> <i class="fa fa-plus"></i>
                  </button></strong>
                  <div class="">
                    <div id="newinput"></div>
                    <!-- <?php
            $in_question = mysqli_query($con, 'INSERT INTO form_question (question, cat_id, service_id)VALUES("'.$question.'","'.$category_id.'", "'.$service_id.'")');
                    ?> -->

                    <div align="center" style="padding-top:3%;"> <input type="submit" class="btn btn-info" name="submit"></div>
        </form>
      </div></div>




      <?php }elseif(isset($_GET['edit'])){ 
$serv=mysqli_query($con,"SELECT `id`, `catid`, `name`,`sdetail`, `cost`, `advrequired`, `advper`, `duedays`, `duepay`, `type`, `pic`, `timedate` FROM `service` WHERE `id`='".trim($_GET['edit'])."'");
$runservicef=mysqli_fetch_array($serv); ?>
    <form action="#" method="post" enctype="multipart/form-data">
  <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="color:#000;">Update Service</h3>
            </div>
            <div class="box-body">
       
            <div class="row" style="margin-top: 20px; margin-left: 5px;margin-right: 5px">
               <div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label>Service Category :<span style="color:red"></span></label>
                        <select class="form-control" name="category" required="required">
                           <option value="<?php echo $runservicef['catid'] ?>"><?php echo GetCatName($runservicef['catid']); ?></option>
                          <?php $service=mysqli_query($con,"SELECT `id`, `cast`, `timedate` FROM `cat` ORDER BY `cast` ASC");while($runservice=mysqli_fetch_array($service)){?>
                            <option value="<?php echo $runservice['id']; ?>"><?php echo ucwords($runservice['cast']); ?></option>
                          <?php }?>
                        </select>
                    </div>
                </div>
           
            <div class=col-sm-6>
                    <div class="form-group mb-10">
                        <label> Service Name<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="name" maxlength="225" required placeholder="Enter Here" value="<?php echo ucwords($runservicef['name']); ?>" />
                    </div>
                </div>
                <div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label> Service Cost<span style="color:red">*</span></label>
                        <input type="text" class="form-control" name="servicecost" maxlength="10" required placeholder="Enter Here" value="<?php echo ($runservicef['cost']); ?>" />
                    </div>
                </div>
                <div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label> Advance Required </label>
                       <select class="form-control" name="advance">
                        <option value="<?php echo ($runservicef['advrequired']); ?>"><?php echo ucwords($runservicef['advrequired']); ?></option>

<option value="yes">Yes</option>
<option value="no">No</option></select>
                    </div>
                </div>
                 
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Advance Percentage(%)</label>
                        <input type="text" class="form-control" name="advancepercentage" placeholder="Enter Here" value="<?php echo ucwords($runservicef['advrequired']); ?>"/>   
                    </div>
                </div>    
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Service Due Days </label>
                        <input type="text"  class="form-control" name="serviceduedays" placeholder="Enter Here" value="<?php echo ($runservicef['duedays']); ?>"/>
                    </div>
                </div>
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Payment Due Days </label>
                        <input type="text" class="form-control" name="paymentduedays" placeholder="Enter Here" value="<?php echo round($runservicef['duepay'],0); ?>"/>
                    </div>
                </div>
                <div class=col-sm-4>
                    <div class="form-group mb-10">
                        <label>Service Type</label>
                <select class="form-control" name="servicetype">
                  <option value="<?php echo ($runservicef['type']); ?>"><?php echo ucwords($runservicef['type']); ?></option>
<option value="onetime">One Time</option>
<option value="recurrent">Recurrent</option>
</select>
                    </div>
                </div><div class=col-sm-3>
                    <div class="form-group mb-10">
                        <label>Image</label>
                        <img src="../images/<?php echo $runservicef['pic'];?>" style="height: 100px; width:150px;">
                       <input type="file" name="pic">
                    </div>
                </div> 

    <!--            
                <div class=col-sm-12></div>
                   
            <div align="center"><br/><input type="submit" class="btn btn-info" name="update" style="width:30%;" value="Update" /></div> -->
            
        </div>         

          <label>Service Detail</label>  <textarea type="textarea" name="servicedetail" rows="4" cols="120" placeholder="About the service detail" ><?php if(!empty($runservicef['sdetail'])){echo $runservicef['sdetail'];}else{echo 'About the service detail will be here';} ?></textarea>


<br><br><br><br>



<!-- multi question -->
  <h2 style="color:green"></h2>
  <div style="container">

  <strong> Add and Delete Form Questions Dynamically   <button id="rowAdder" type="button" class="btn btn-dark">
            <span class="bi bi-plus-square-dotted">
            </span> <i class="fa fa-plus"></i>
          </button></strong>
    <div class="">
      <div id="newinput"></div>
      <!--  -->
      <?php //echo trim($_GET['edit']);
      if(trim($_GET['edit'])>0){
$qq = mysqli_query($con, 'SELECT * FROM form_question WHERE service_id="'.trim($_GET['edit']).'"');
$qnrcheck = mysqli_num_rows($qq);
 //echo $qnrcheck;
 $q_no =0;
while($qrows = mysqli_fetch_assoc($qq)){ echo ++$q_no;?>
        <div class="col">
          <div id="row">
            <div class="input-group col-lg-8">
              <div class="input-group-prepend">
                <button class="btn btn-danger"
                    id="DeleteRow"
                    type="button">
                  <i class="fa fa-remove"></i>
<!--                                   <i class="fa fa-trash"></i>
 -->
                </button>
              </div>
              <input type="text" class="form-control m-input" name="multi_question[]" value="<?php  echo $qrows['question'];?>">

              <input type="hidden" name="question_exist" value="yes">
            </div>
          </div>

      

          <?php //echo $qnrcheck; echo $q_no;
//if($q_no == $qnrcheck){
          ?>
          <?php //}?>
        </div>
      <?php }?>
    <?php }else{?>
   <div class="col">
          <div id="row">
            <div class="input-group col-lg-8">
              <div class="input-group-prepend">
                <button class="btn btn-danger"
                    id="DeleteRow"
                    type="button">
                  <i class="fa fa-remove"></i>
                </button>
              </div>
              <input type="text" class="form-control m-input" name="multi_question[]">
            </div>
          </div>
          <div id="newinput"></div>
          
        </div>
              <?php }?>

        <!--  -->
      </div>
      
        <hr/>
      <p>  <a href="service?did=<?php echo trim($_GET['edit']); ?>" class="btn btn-danger btn-lg" onclick="return confirm('Do You Want To Remove')">Do You Want To Delete?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button href="./?submit" class="btn btn-info btn-lg" type="submit" name="update">Save</button></p>
      </div></div>

      <!-- multi question -->
        </form>

<?php }elseif(isset($_GET['docsr'])){ 
$serv=mysqli_query($con,"SELECT `id`, `catid`, `name`, `cost`, `advrequired`, `advper`, `duedays`, `duepay`, `type`, `pic`, `timedate` FROM `service` WHERE `id`='".trim($_GET['docsr'])."'");
$runservicef=mysqli_fetch_array($serv); ?>
  <div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="color:#000;">Update Service</h3>
            </div>
            <div class="box-body">
           <form action="#" method="post" enctype="multipart/form-data">
            <div class="row" style="margin-top: 20px; margin-left: 5px;margin-right: 5px">
               <div class=col-sm-6>
                                       <div class="form-group mb-10">
                        <label>Required Documents:<span style="color:red"></span></label>
    <select class="form-control select2" multiple="multiple" data-placeholder="Select Documents"
                        style="width: 100%;" name="documents[]" id="documentlist"> 
<?php
$dcs=mysqli_query($con,"SELECT `id`,`name`, `type`FROM `documentlist` ORDER BY `name` ASC");while($doctsrun=mysqli_fetch_array($dcs)){?>
<option value="<?php echo ucwords($doctsrun['id']); ?>"><?php echo ucwords($doctsrun['name']);// echo ucwords($doctsrun['type']);?></option>
<?php }?></select></div>
                 <!--    <div id="result"></div> -->
                </div>
             <!-- result list table starts -->
            <div class=col-sm-6><label style="text-align:center;"><i class="fa fa-check-circle-o text-green"></i> Required Document</label>
             <ul><?php for($i=0; $i<count(getServiceList(trim($_GET['docsr']))); $i++) { 
  echo '<li><div class="box box-default box-sm"><div class="box-header with-border"><h3 class="box-title">'.getServiceList(trim($_GET['docsr']))[$i].'</h3><div class="box-tools pull-right">';?>
  <a href="service?docsr=<?php echo trim($_GET['docsr']);?>&serdel=<?php echo getServiceList(trim($_GET['docsr']))[$i];?>" class="btn btn-box-tool" onclick="return confirm('Confirm to Delete')"><i class="fa fa-times"></i></a></div>
  <!-- result list table ends -->
</div></div></li>
<?php }?></ul>
                   </div>
        
                <div class=col-sm-12></div>
                   </div><?php   ?>
            <div align="center"><br/><input type="submit" class="btn btn-info" name="docupdate" style="width:30%;" value="Update" /></div>
           
        </div>
        </form>
      </div></div>


      <?php }else{?>
<div class="box box-default box-solid">
            <div class="box-header with-border">
              <h3 class="box-title" style="color:#000;">Category List</h3>
               <div class="box-tools pull-right">
                <a href="service?add" type="button" class="btn btn-warning" style="border-radius:20%;color:#fff;">+ Add New</a>
              </div>
            </div>

            <div class="box-body">
            <div class="row" style="margin-top: 20px; margin-left: 5px;margin-right: 5px">
           <table class="table table-striped" id="example1">
                <thead>
                  <tr><th>Sno.</th><th>Category</th><th>Service</th><th>Cost</th><th>Required Advance</th><th>Advance Per</th><th>Documents List</th><th>Action</th></tr>
                </thead>
                <tbody>
                  <tr> 
                 <?php $x=1;
          $ress=mysqli_query($con,"SELECT `id`, `catid`, `name`, `cost`, `advrequired`, `advper`, `duedays`, `duepay`, `type`, `timedate` FROM `service` ORDER BY `name` ASC");
           while($rows=mysqli_fetch_array($ress)){?>
<td><?php echo $x; ?>.</td><td><?php echo ucwords(GetCatName($rows['catid'])); ?></td><td><?php echo ucwords($rows['name']); ?></td><td><?php echo ($rows['cost']); ?></td><td><?php echo ($rows['advrequired']); ?></td><td><?php echo ($rows['advper']); ?></td><td><ul><?php
for($i=0; $i < count(getServiceList($rows['id'])); $i++) { 
  echo '<li>'.getServiceList($rows['id'])[$i].'</li>'; 
}?></ul><div style="text-align:right;"><a href="service?docsr=<?php echo $rows['id']; ?>" class="btn btn-link btn-sm" style="color:orange;font-weight: bold;">Update</a></div></td>
<td><a href="service.php?edit=<?php echo $rows['id']; ?>" class="btn btn-default btn-sm"><i class="fa  fa-gears"></i> Manage</a></td>
                  </tr>
                  <?php  $x++;} ?>
                 
                </tbody>
              </table>
      <?php }?>
</div></section></div>
<script src=""></script>
<script type="text/javascript">
$('#documentlist').on('change',function(){
  var vl=$(this).val();
for (var i = 0, count = vl.length; i < count; i++) {
  //alert(count);
    message += '<li><span>' + vl[i] + '</span><span>';
}
 $('#result').html(message);  
});
</script>
<?php include_once 'footer.php'; ?>
  <script type="text/javascript">
  //new
    $("#rowAdder").click(function () {
      newRowAdd =
        '<div id="row"> <div class="input-group m-3">' +
        '<div class="input-group-prepend">' +
        '<button class="btn btn-danger" id="DeleteRow" type="button">' +
        '<i class="fa fa-remove"></i></button> </div>' +
        '<input type="text" class="form-control m-input " name="multi_question[]"> </div> </div>';
      $('#newinput').append(newRowAdd);
    });
    $("body").on("click", "#DeleteRow", function () {
      $(this).parents("#row").remove();
    })
    //new

//Add_new
$("#rowwAdder").click(function () {
  newRowAdd = 
  `<div id="row"> <div class="input-group m-3">` +
        `<div class="input-group-prepend">` +
          `<button class="btn btn-danger" id="DeleteRow" type="button">` +
            `<i class="fa fa-remove"></i></button> </div>` +
        `<input type="text" class="form-control m-input" name="multi_question[]" style="width:1215px;"> </div> </div>`;
  $('#newinput').append(newRowAdd);
});

$(document).on("click", "#DeleteRow", function () {
  $(this).closest("#row]").remove();
});
//Add_new
  </script>