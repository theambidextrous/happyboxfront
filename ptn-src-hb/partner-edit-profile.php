                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Happy Box:: Partner Edit Profile</title>
  <!-- Bootstrap core CSS -->
 <?php include '../shared/partials/css.php'; ?>

</head>

<body>
  <!-- Navigation -->
 <?php include '../shared/partials/nav-logged-in.php'; ?>
 
<section class="partner_edit_pro section_60">
         <div class="container ">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                          <h3 class="partner_blueh text-center">EDIT YOUR PARTNER PROFILE?</h3>
                 
                        
                    </div>
                      <div class="col-md-10">
                          <div class="row justify-content-center blue_label">
                              <div class="col-md-5">
                                      <form class="become_partner ">
						<div class="form-group">
<label>Company Name</label>
<input type="text" name="company" class="form-control rounded_form_control" placeholder="Required Field">
</div>
<div class="form-group">
<label>Contact Person's Name</label>
<input type="text" name="contact" class="form-control rounded_form_control" placeholder="Required Field">
</div>
                                          <div class="form-group">
<label>Email Address</label>
<input type="email" name="email" class="form-control rounded_form_control" placeholder="Required Field">
</div>                                       
 </div>
                                <div class="col-md-5">
                                                 
						<div class="form-group">
<label>Business Category</label>
  <select class=" form-control rounded_form_control" name="businesscat">
                                        <option value="">Select an option</option>
                                        <option>Option 1</option>
                                        <option>Option 2</option>
                                        <option>Option 3</option>
                                    </select>
</div>
<div class="form-group">
<label>Surname</label>
<input type="text" name="surname" class="form-control rounded_form_control" placeholder="Required Field">
</div>
                                          <div class="form-group">
<label>Contact Mobile Number</label>
<input type="text" name="mobile" class="form-control rounded_form_control" placeholder="Required Field">
</div> 
                                                                       <div class="form-group">
<label>Business Location</label>
<input type="text" name="location" class="form-control rounded_form_control" placeholder="Required Field">
</div>
                                      <button type="submit" class="btn btn_rounded btn-dark-blue">UPDATE MY PROFILE</button>
                                  
                                  
                              </div>
                              	</form>
                              
                              
                          </div>
                        
                    </div>
                    
                </div>
              
		
               
                </div>
        </section>

<?php include '../shared/partials/loggedin-footer.php';?>
  <!-- Page Content -->

  <!-- Bootstrap core JavaScript -->
  
<?php include '../shared/partials/js.php';?>
   
  
 
 

</body>

</html>
