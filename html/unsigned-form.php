<?php include "include/header.php" ?>
<?php include "include/menu.php" ?>


<section class="contact-form">
     <div class="container">
          <div class="row">
               <div class="col-lg-12">
                    <div class="back_leaf">
                         <h2> please fill out the form<span class="type_span" data-typetext="below"> </span> </h2>
                    </div>
                    <div class="full-form-fill">
                         <form>
                              <div class="row">
                                   <div class="col-4">
                                        <input type="text" name="name" class="form-control" placeholder="Username" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="password" name="password" class="form-control" placeholder="Confirm" required="">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-6">
                                        <input type="email" name="email" class="form-control" placeholder="E-Mail" required="">
                                   </div>
                                   <div class="col-6">
                                        <input type="text" name="group" class="form-control" placeholder="Group" required="">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-4">
                                        <input type="text" name="name" class="form-control" placeholder="First Name" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="text" name="name" class="form-control" placeholder="Last Name" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="text" name="age" class="form-control" placeholder="Age" required="">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-6">
                                        <input type="text" name="gender" class="form-control" placeholder="Gender" required="">
                                   </div>
                                   <div class="col-6">
                                        <input type="text" name="address" class="form-control" placeholder="Address" required="">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-4">
                                        <input type="text" name="city" class="form-control" placeholder="City" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="text" name="state" class="form-control" placeholder="State" required="">
                                   </div>
                                   <div class="col-4">
                                        <input type="text" name="postal" class="form-control" placeholder="Postal" required="">
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-12">
                                        <textarea name="message" class="form-control" id="textarea" cols="30" rows="8" placeholder="Biography" required=""></textarea>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-12 text-center">
                                        <button class="btn blue-btn" type="submit">Register</button>
                                   </div>
                              </div>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</section>





<?php include "include/newsletter.php" ?>


<?php include "include/footer.php" ?>