<?php include_once 'header.php'; 
if(isset($_POST['servicesubmit'])){

	$refercode=mysqli_real_escape_string($con,$_POST['refer']);
	$email=mysqli_real_escape_string($con,$_POST['mail']);
	$contact=mysqli_real_escape_string($con,$_POST['cmob']);
	$city=mysqli_real_escape_string($con,$_POST['city']);
	$name=mysqli_real_escape_string($con,$_POST['cname']);
	$service=mysqli_real_escape_string($con,$_POST['serviceid']);
	$cid=mysqli_real_escape_string($con,$_POST['catid']);
	$fcost=mysqli_real_escape_string($con,$_POST['formcost']);
  $distamt=mysqli_real_escape_string($con,$_POST['distramt']);

$refer=mysqli_query($con,"SELECT `eno` FROM `ecounter` WHERE `memcode`='$refercode'")or die(mysqli_error($con));
if(empty(mysqli_num_rows($refer))){
$refermem=0;
}else{
$referrn=mysqli_fetch_array($refer);
$refermem=$referrn['eno'];
}

$checkq=mysqli_query($con,"SELECT id FROM customer WHERE contact='$contact'")or die(mysqli_error($con));
if(empty(mysqli_num_rows($checkq))){
$query=mysqli_query($con,"INSERT INTO `customer`(`name`,`contact`,`city`) VALUES ('$name','$contact','$city')")or die(mysqli_error($con));
 $custid_id=mysqli_insert_id($con);
}else{
$rrr=mysqli_fetch_array($checkq);
$custid_id=$rrr['id'];
}
$sqll=mysqli_query($con,"INSERT INTO `task`(`applicantid`,`taskid`,`catid`,`mrp`,`taskamt`,`status`,`ip`) VALUES ('$custid_id','$service','$refermem','$fcost','$distamt',1,'$ip')")or die(mysqli_error($con));
if($sqll>0){
	header("Location: thankyou");
}else{
    echo "<script>alert('Server Busy')</script>";
}
}
?><section id="hero">

    <div class="container">
      <div class="row justify-content-between">

</div></div></section>

<section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Document Requirements</h2>
          <p><?php echo ServiceName(trim($_GET['id']));?></p>
        </div>

        <div class="row">

          <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
            <div class="info"><ul>
              <?php
$service=mysqli_query($con,"SELECT `document` FROM `servicedoc` WHERE `serviceid`='".trim($_GET['id'])."'");
while($servicerun=mysqli_fetch_array($service)){?>
 <li> <?php echo ucwords($servicerun['document']);?> </li><?php }?>
</ul>
</div>
</div>
<div class="col-lg-8" data-aos="fade-left" data-aos-delay="200"><p>Fill Your Details  For: <b><?php echo ServiceName(trim($_GET['id']));?></b></p>
<form method="post" class="form-control">
<div class="form-group">
<input type="hidden" name="serviceid" value="<?php echo trim($_GET['id']); ?>" required="required">
<input type="hidden" name="catid" value="<?php echo CatidByCatid(trim($_GET['id'])); ?>" required="required">
<input type="hidden" name="formcost" value="<?php echo ServiceNameAmt(trim($_GET['id'])); ?>" required="required">
<input type="hidden" name="distramt" value="<?php echo ServiceCashAmt(trim($_GET['id'])); ?>" required="required">
<input type="text" name="cname" pattern="^[a-z A-Z]*$" minlength="2" maxlength="30" class="form-control" id="cus_name" placeholder="Applicant Name*" required="required">
</div>
<br/>
<div class="form-group">
<input type="text" name="city" minlength="2" maxlength="30" pattern="^[a-z A-Z]*$"class="form-control" id="cus_email" placeholder="Your City*" required="required" >
</div><br/>
<div class="form-group">
<input type="text" name="cmob" minlength="10" maxlength="10" pattern="^[0-9]+" class="form-control" id="cus_phone" placeholder="Contact Number*" required="required">
</div><br/>
<div class="form-group">
<input type="email" name="mail" class="form-control" id="cus_phone" placeholder="Email Id">
</div><br/>
<div class="form-group">
<input type="text" name="refer" class="form-control" id="cus_phone" placeholder="Referel Code?">
</div><br/>
</div>
<div class="form-group text-center"><div align="center"><br/>
<button type="submit" name="servicesubmit" class="btn btn-primary btn-lg">Submit</button></div>
</div>
</form>
              
          </div>

        </div>

      </div>
    </section>
</div><?php include_once 'footer.php'; ?>