<?php


// Login Check
    $app->post('/user/login/',function($request, $response, $args){
         header('Access-Control-Allow-Origin: *'); 
        $user_data = $request->getParsedBody();
        $user_email = $user_data['email'];
        $user_password = md5($user_data['password']);
        $login_check = "SELECT * FROM user_details WHERE user_email = '".$user_email."' AND user_password = '".$user_password."' ";         
        $login_test_stmt = $this->db->prepare($login_check);
        $login_test_stmt->execute();
         $login_details = $login_test_stmt->fetchAll();
        
        return $this->response->withJson($login_details);
    });

// get all gym owner
    $app->get('/user/gymowner/',function($request, $response, $args){
         header('Access-Control-Allow-Origin: *'); 
        $user_data = $request->getParsedBody();
        $user_role = 'GYMOWNER';
        //$user_password = md5($user_data['password']);
        $login_check = "SELECT * FROM user_details WHERE user_role = '".$user_role."'";         
        $login_test_stmt = $this->db->prepare($login_check);
        $login_test_stmt->execute();
         $login_details = $login_test_stmt->fetchAll();
        
        return $this->response->withJson($login_details);
    });

 // Add user
       $app->post('/add/user/',function($request, $response, $args){
         header('Access-Control-Allow-Origin: *'); 
        $user_data = $request->getParsedBody();
        //$user_email = $user_data['email'];
        return $this->response->withJson($input);
        $current_date = date('Y/m/d');
        $current_time = date("h:i:sa");
        $password_combination = $args['user_fname'].$args['user_phone'];
        $user_password = md5($password_combination);
        $login_check = "INSERT INTO user_details(`user_fname`,`user_lname`,`user_phone`,`user_email`
        ,`user_registration_date`,`user_registration_time`,`user_date_of_birth`,`user_password`,
        ,`user_address`,`user_role`,`user_country`,`user_state`,`user_city`,`goverment_it_type`,`id_serial_number`)
        VALUES(:user_fname,:user_lname,:user_phone,:user_email,:user_registration_date,:user_registration_time,
        ,:user_date_of_birth,:user_password,
        ,:user_address,:user_role,:user_country,:user_state,:user_city,:goverment_id_type,:id_serial_number)";         
         $sth->bindParam("user_fname", $input['user_fname']);
         $sth->bindParam("user_lname", $input['user_lname']);
         $sth->bindParam("user_phone", $input['user_phone']);
         $sth->bindParam("user_email", $input['user_email']);
         $sth->bindParam("user_registration_date", $current_date);
         $sth->bindParam("user_registration_time", $current_time);
         $sth->bindParam("user_date_of_birth", $input['user_date_of_birth']);
       //  $sth->bindParam("user_image_id", $args['user_image_id']);
         $sth->bindParam("user_password", $user_password);
       //  $sth->bindParam("user_jwt_token", $args['user_jwt_token']);
         $sth->bindParam("user_address", $input['user_address']);
         $sth->bindParam("user_role", $input['user_role']);
         $sth->bindParam("user_country", $input['user_country']);
         $sth->bindParam("user_state", $input['user_state']);
         $sth->bindParam("user_city", $input['user_city']);
         $sth->bindParam("goverment_id_type", $input['goverment_id_type']);
         $sth->bindParam("id_serial_number", $input['id_serial_number']);
        $login_test_stmt = $this->db->prepare($login_check);
        $login_test_stmt->execute();
         $login_details = $login_test_stmt->fetchAll();
        
       // return $this->response->withJson($login_details);
    });
// get all gym name using gymowner id


$app->get('/gymowner/gym/[{gymowner_id}]', function($request, $response, $args){
      $sth = $this->db->prepare("SELECT * FROM `gym_registration` WHERE owner_id = :owner_id");
        $sth->bindParam("owner_id", $args['gymowner_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    
    });



 // Add GYM
  
$app->post('/add/gym/[{user_id}]', function ($request, $response, $args) 
{
    $current_date = date('Y/m/d');
    $current_time = date("h:i:sa");
   
    $input = $request->getParsedBody();
    $add_test_sql = "INSERT INTO gym_registration(`gym_name`,`gym_country`,`gym_state`,`gym_city`
    ,`gym_address`,`gym_phone`,`gym_created_date`,`gym_created_time`,`gym_morning_open`,`gym_morning_close`,`gym_evening_open`,`gym_evening_close`,`owner_id`)VALUES(:gym_name,:gym_country,:gym_state,:gym_city,:gym_address,:gym_phone,
    :gym_created_date,:gym_created_time,:gym_morning_open,:gym_morning_close,:gym_evening_open,:gym_evening_close,:gym_owner_id)";
    
/*    ,`gym_country`,`gym_state`,`gym_city`
        ,`gym_address`,`gym_phone`,`gym_created_date`,`gym_created_time`,
        ,`gym_morning_open`,`gym_morning_close`,`gym_evening_open`,`gym_evening_close`,`owner_id`)
        VALUES(:gym_name,:gym_country,:gym_state,:gym_city,:gym_address,:gym_phone,:gym_created_date,:gym_created_time,
        ,:gym_morning_open,:gym_morning_close,:gym_evening_open,:gym_evening_close,:gym_owner_id)"; 
      */
         $sthl = $this->db->prepare($add_test_sql); 
         $sthl->bindParam("gym_name", $input['gym_name']);
         $sthl->bindParam("gym_country", $input['gym_country']);
         $sthl->bindParam("gym_state", $input['gym_state']);
         $sthl->bindParam("gym_city", $input['gym_city']);
         $sthl->bindParam("gym_address", $input['gym_address']);
         $sthl->bindParam("gym_phone", $input['gym_phone']);
         $sthl->bindParam("gym_created_date", $current_date);
         $sthl->bindParam("gym_created_time", $current_time);
  
        $sthl->bindParam("gym_morning_open", $input['gym_morning_open']);
         $sthl->bindParam("gym_morning_close", $input['gym_morning_close']);
         $sthl->bindParam("gym_evening_open", $input['gym_evening_open']);
         $sthl->bindParam("gym_evening_close", $input['gym_evening_close']);

         $sthl->bindParam("gym_owner_id", $args['user_id']);
         $sthl->execute();
   
     
   
   
   
   
    $update="inserted Successfully";
        
    return $this->response->withJson($update);
 });
    
// get Gym details by gym id
    $app->get('/gym/[{gym_id}]', function ($request, $response, $args) {
  $sth = $this->db->prepare("SELECT * FROM `gym_registration` WHERE gym_id = :gym_id");
        $sth->bindParam("gym_id", $args['gym_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

 // get the list of gymTrainer by gymID
 $app->get('/gymTrainer/[{gymid}]', function ($request, $response, $args) {
    
    
         $sth = $this->db->prepare("SELECT * FROM `gym_trainer` WHERE `gym_id_linked` = :gym_id");
         $sth->bindParam("gym_id", $args['gymid']);
        $sth->execute();
        $todos = $sth->fetchAll();
        $abc = "call success";
    //    return $abc;
        return $this->response->withJson($todos);
    });
    
 // add trainer to a gym by gym id
 
$app->post('/addTrainer/[{gym_id}]', function ($request, $response, $args) 
{
    $current_date = date('Y/m/d');
    $current_time = date("h:i:sa");
   
    $input = $request->getParsedBody();

    $add_test_sql = "INSERT INTO gym_trainer(`trainer_name`,`trainer_last_name`,`trainer_email`,`trainer_gender`,
    `trainer_age`,`trainer_height`,`trainer_weight`,`trainer_country`,`trainer_state`,`trainer_city`
    ,`trainer_address`,`trainer_phone`,`trainer_created_date`,`trainer_created_time`,`gym_id_linked`,`trainer_image`,
    `trainer_chest`,`experience`,`salary`,`awards_medals`)
    VALUES(:trainer_name,:trainer_last_name,:trainer_email,:trainer_gender,:trainer_age,:trainer_height,
    :trainer_weight,:trainer_country,:trainer_state,:trainer_city,:trainer_address,:trainer_phone,
    CURDATE(),CURTIME(),:gym_id_linked,:trainer_image,:trainer_chest,:trainer_experience,:trainer_salary,:awards_medals)";
    
/*    ,`gym_country`,`gym_state`,`gym_city`
        ,`gym_address`,`gym_phone`,`gym_created_date`,`gym_created_time`,
        ,`gym_morning_open`,`gym_morning_close`,`gym_evening_open`,`gym_evening_close`,`owner_id`)
        VALUES(:gym_name,:gym_country,:gym_state,:gym_city,:gym_address,:gym_phone,:gym_created_date,:gym_created_time,
        ,:gym_morning_open,:gym_morning_close,:gym_evening_open,:gym_evening_close,: gym_owner_id)"; 
      */
         $sthl = $this->db->prepare($add_test_sql); 
         $sthl->bindParam("trainer_name", $input['trainer_name']);
         $sthl->bindParam("trainer_last_name", $input['trainer_last_name']);
         $sthl->bindParam("trainer_email", $input['trainer_email']);
         $sthl->bindParam("trainer_gender", $input['trainer_gender']);
         $sthl->bindParam("trainer_age", $input['trainer_age']);
         $sthl->bindParam("trainer_height", $input['trainer_height']);
         $sthl->bindParam("trainer_weight", $input['trainer_weight']);
         $sthl->bindParam("trainer_country", $input['trainer_country']);
        $sthl->bindParam("trainer_state", $input['trainer_state']);
         $sthl->bindParam("trainer_city", $input['trainer_city']);
         $sthl->bindParam("trainer_address", $input['trainer_address']);
         $sthl->bindParam("trainer_phone", $input['trainer_phone']);
         //$sthl->bindParam("trainer_created_date", CURDATE());
         //$sthl->bindParam("trainer_created_time", CURTIME());
         $sthl->bindParam("gym_id_linked", $args['gym_id']);
         $sthl->bindParam("trainer_image", $input['trainer_image']);
         $sthl->bindParam("trainer_experience", $input['trainer_experience']);
         $sthl->bindParam("trainer_salary", $input['trainer_salary']);
         $sthl->bindParam("trainer_chest", $input['trainer_chest']);
         $sthl->bindParam("awards_medals", $input['awards_medals']);
         $sthl->execute();
   
     
   
   
   
   
    $update="inserted Successfully";
        //    return $this->response->withJson($update);
    return $this->response->withJson($input);
 });
    
 // add customer to a gym by gym id   
    
 $app->post('/addCustomer/[{gym_id}]', function ($request, $response, $args) 
{
   // return $this->response->withJson($request);
    $current_date = date('Y/m/d');
    $current_time = date("H:i:s");
    $status = "ACTIVE";
    $input = $request->getParsedBody();
    $customer_image = $args['customer_image'];
    
  // return $this->response->withJson($input);
    $add_test_sql = "INSERT INTO `gym_customer`(`customer_name`,
    `customer_last_name`, `customer_phone`, `customer_email`, `customer_age`, `customer_address`,
    `customer_city`, `customer_state`, `customer_country`, `customer_weight`, `customer_height`,
    `customer_registration_date`, `customer_registration_time`, `customer_status`,
    `customer_plan`, `gym_id_assigned`, `customer_gender`,`customer_image`) VALUES
    (:customer_name,
    :customer_last_name, :customer_phone, :customer_email, :customer_age, :customer_address,
    :customer_city, :customer_state, :customer_country, :customer_weight, :customer_height,
    :customer_registration_date, :customer_registration_time, :customer_status,
    :customer_plan, :gym_id_assigned, :customer_gender,:customer_image)";
    
/*    ,`gym_country`,`gym_state`,`gym_city`
        ,`gym_address`,`gym_phone`,`gym_created_date`,`gym_created_time`,
        ,`gym_morning_open`,`gym_morning_close`,`gym_evening_open`,`gym_evening_close`,`owner_id`)
        VALUES(:gym_name,:gym_country,:gym_state,:gym_city,:gym_address,:gym_phone,:gym_created_date,:gym_created_time,
        ,:gym_morning_open,:gym_morning_close,:gym_evening_open,:gym_evening_close,: gym_owner_id)"; 
      */
        $abcd = $this->db;
         $sthl = $this->db->prepare($add_test_sql); 
         $sthl->bindParam("customer_name", $input['customer_name']);
         $sthl->bindParam("customer_last_name", $input['customer_last_name']);
         $sthl->bindParam("customer_email", $input['customer_email']);
         $sthl->bindParam("customer_gender", $input['customer_gender']);
         $sthl->bindParam("customer_age", $input['customer_age']);
         $sthl->bindParam("customer_height", $input['customer_height']);
         $sthl->bindParam("customer_weight", $input['customer_weight']);
         $sthl->bindParam("customer_country", $input['customer_country']);
         $sthl->bindParam("customer_state", $input['customer_state']);
         $sthl->bindParam("customer_city", $input['customer_city']);
         $sthl->bindParam("customer_address", $input['customer_address']);
         $sthl->bindParam("customer_phone", $input['customer_phone']);
         $sthl->bindParam("customer_registration_date", $current_date);
         $sthl->bindParam("customer_registration_time", $current_time);
         $sthl->bindParam("customer_status", $status);
         $sthl->bindParam("gym_id_assigned", $args['gym_id']);
         $sthl->bindParam("customer_plan", $input['customer_plan']);
         $sthl->bindParam("customer_image", $input['customer_image']);
         $sthl->execute();
        
          
       //  $customer_id = $sthl->db->lastInsertId();
         $customer_id = $abcd->lastInsertId();
        // return $current_id;
       
        $package_id = $input['customer_plan'];
        $gym_id = $args['gym_id'];
        $add_test_sql2 = "SELECT * FROM `gym_packages` WHERE `gym_package_id` = :gym_package_id AND `gym_id` = :gym_id";
        $sthl1 = $this->db->prepare($add_test_sql2); 
        $sthl1->bindParam("gym_package_id", $package_id);
        $sthl1->bindParam("gym_id", $gym_id);
        $sthl1->execute();
        $todos = $sthl1->fetchAll();
        
        $planDetails =$todos;
       // return $this->response->withJson($planDetails);
        $planDuration = $planDetails[0]['package_duration'];
     //   return $planDuration;
        $today = time();
        $endDate = strtotime("+".$planDuration, $today);
        $expire = date('y-m-d', $endDate);

         
         
           $add_test_sql1 = "INSERT INTO `gym_customer_details`(
    `gym_id`, `customer_id`, `package_id`, `trainer_id`, `plan_joining`,
    `plan_expiry`) VALUES
    (:gym_id, :customer_id, :package_id, :trainer_id, CURDATE(),
    :plan_expiry)";
    


         $sthl1 = $this->db->prepare($add_test_sql1); 
         $sthl1->bindParam("gym_id", $args['gym_id']);
         $sthl1->bindParam("customer_id", $customer_id);
         $sthl1->bindParam("package_id", $input['customer_plan']);
         $sthl1->bindParam("trainer_id", $input['trainer_id']);
         
         $sthl1->bindParam("plan_expiry", $expire);

         $sthl1->execute();
   
     
   
   
   
   
    $update="inserted Successfully";
        
    //return $this->response->withJson($add_test_sql);
      return $this->response->withJson($update);
 });   
    
// get the list of gym customer by gym id
$app->get('/gymCustomer/[{gymid}]', function ($request, $response, $args) {
    
         $gym_id = $args['gymid'];   
         $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE `gym_id_assigned` = :gym_id");
         $sth->bindParam("gym_id", $args['gymid']);
        $sth->execute();
        $todos = $sth->fetchAll();
        $abc = "call success";
    //    return $abc;
        return $this->response->withJson($todos);
    });

 // to get the gym package list by gym id   
$app->get('/gymPackage/[{gymid}]', function ($request, $response, $args) {
    
    
         $sth = $this->db->prepare("SELECT * FROM `gym_packages` WHERE `gym_id` = :gym_id");
         $sth->bindParam("gym_id", $args['gymid']);
        $sth->execute();
        $todos = $sth->fetchAll();
        $abc = "call success";
    //    return $abc;
        return $this->response->withJson($todos);
    });
 
 // to add a package for gym
 $app->post('/addPackage/[{gym_id}]', function ($request, $response, $args) 
{
    $current_date = date('Y/m/d');
    $current_time = date("h:i:sa");
   
    $input = $request->getParsedBody();
    $add_test_sql = "INSERT INTO gym_packages(`package_name`,`package_duration`,`package_price`,`gym_plan_create_date`,`gym_plan_create_time`,`gym_id`)
    VALUES(:package_name,:package_duration,:package_price,:gym_plan_create_date,:gym_plan_create_time,:gym_id)";
    

         $sthl = $this->db->prepare($add_test_sql); 
         $sthl->bindParam("package_name", $input['package_name']);
         $sthl->bindParam("package_duration", $input['package_duration']);
         $sthl->bindParam("package_price", $input['package_price']);
         $sthl->bindParam("gym_plan_create_date", $current_date);
         $sthl->bindParam("gym_plan_create_time", $current_time);
         $sthl->bindParam("gym_id", $args['gym_id']);
         $sthl->execute();
      
       $update="inserted Successfully";
        
    return $this->response->withJson($update);
 });
    // To get the List of Gym Trainer for a gym 
 $app->get('/trainerRegistered/[{gym_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_trainer` WHERE gym_id_linked = :gym_id");
    $sth->bindParam("gym_id", $args['gym_id']);
    $sth->execute();
    $trainerRegistered = $sth->fetchAll();
    return $this->response->withJson($trainerRegistered);
    });
 
 // get a list of gym trainer all gyms
 
 $app->get('/trainerRegisteredAll/',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_trainer`");
  //  $sth->bindParam("gym_id", $args['gym_id']);
    $sth->execute();
    $trainerRegistered = $sth->fetchAll();
    return $this->response->withJson($trainerRegistered);
    });
 
 // Total gym registered By user
 $app->get('/gymCountAll/[{owner_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_registration` WHERE owner_id = :owner_id");
    $sth->bindParam("owner_id", $args['owner_id']);
    $sth->execute();
    $gymCount = $sth->fetchAll();
    return $this->response->withJson($gymCount);
    });
 
// Total Packages Registered
  $app->get('/packageCountAll/',function($request, $response, $args){
    $sth = $this->db->prepare(" SELECT * FROM `gym_packages`");
   // $sth->bindParam("owner_id", $args['owner_id']);
    $sth->execute();
    $packageCount = $sth->fetchAll();
    return $this->response->withJson($packageCount);
    });
  
  // Gym Packages by gym id
  
   $app->get('/packageCountGym/[{gym_id}]',function($request, $response, $args){
    $sth = $this->db->prepare(" SELECT * FROM `gym_packages` WHERE gym_id = :gym_id");
    $sth->bindParam("gym_id", $args['gym_id']);
    $sth->execute();
    $packageCountgym = $sth->fetchAll();
    return $this->response->withJson($packageCountgym);
    });
   
   //$app->get('/packageDetails/[{package_id}]',function($request, $response, $args){
   // $sth = $this->db->prepare(" SELECT * FROM `gym_packages` WHERE gym_package_id = :gym_package_id");
   // $sth->bindParam("gym_package_id", $args['package_id']);
   // $sth->execute();
   // $packageCountgym = $sth->fetchAll();
   // return $this->response->withJson($packageCountgym);
   // });


// Total customer Registered
  $app->get('/customerCountAll/',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer`");
   // $sth->bindParam("owner_id", $args['owner_id']);
    $sth->execute();
    $customerCount = $sth->fetchAll();
    return $this->response->withJson($customerCount);
    });
  // TOTAL MALE REGISTERED CUSTOMER
  $app->get('/customerMale/',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE  customer_gender = 'MALE'");
   // $sth->bindParam("owner_id", $args['owner_id']);
    $sth->execute();
    $customerCount = $sth->fetchAll();
    return $this->response->withJson($customerCount);
    });
    // TOTAL FEMALE REGISTERED CUSTOMER
  $app->get('/customerFeMale/',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE  customer_gender = 'FEMALE'");
   // $sth->bindParam("owner_id", $args['owner_id']);
    $sth->execute();
    $customerCount = $sth->fetchAll();
    return $this->response->withJson($customerCount);
    });
  
    // Customer Count By Gym
    $app->get('/customerCountGym/[{gym_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE gym_id_assigned = :gym_id");
    $sth->bindParam("gym_id", $args['gym_id']);
    $sth->execute();
    $customerCount = $sth->fetchAll();
    return $this->response->withJson($customerCount);
    });
 
   $app->get('/gymowner/allCustomer/[{gymOwner_id}]',function($request, $response, $args){
       $sth = $this->db->prepare("SELECT gym_id FROM `gym_registration` WHERE owner_id= :owner_id");
            $sth->bindParam("owner_id", $args['gymOwner_id']);
            $sth->execute();
            $allCustomer = $sth->fetchAll();
        //    return $this->response->withJson($customerCount);
            $customerData = array();
        for($x=0;$x<count($allCustomer);$x++){
            echo $allCustomer[$x]['gym_id'];
            $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE gym_id_assigned= :gym_id");
            $sth->bindParam("gym_id", $allCustomer[$x]['gym_id']);
            $sth->execute();
            $allCustomerData = $sth->fetchAll();
            array_push($customerData,$allCustomerData);
            
        }
        
        return $this->response->withJson($customerData);
    

    
    
    });
 
 
 
   $app->get('/trainerDetails/[{trainer_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_trainer` WHERE trainer_id = :trainer_id");
    $sth->bindParam("trainer_id", $args['trainer_id']);
    $sth->execute();
    $trainerProfile = $sth->fetchAll();
    return $this->response->withJson($trainerProfile);
    });
   
   $app->get('/customerDetails/[{customer_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer` WHERE customer_id = :customer_id");
    $sth->bindParam("customer_id", $args['customer_id']);
    $sth->execute();
    $customerProfile = $sth->fetchAll();
    return $this->response->withJson($customerProfile);
    });
   
   
   
   $app->get('/packageDetails/[{package_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_packages` WHERE gym_package_id = :package_id");
    $sth->bindParam("package_id", $args['package_id']);
    $sth->execute();
    $packageDetails = $sth->fetchAll();
    return $this->response->withJson($packageDetails);
    });
   
   $app->get('/customerPackageDetails/[{customer_id}]',function($request, $response, $args){
    $sth = $this->db->prepare("SELECT * FROM `gym_customer_details` WHERE customer_id = :customer_id");
    $sth->bindParam("customer_id", $args['customer_id']);
    $sth->execute();
    $customerpackageDetails = $sth->fetchAll();
    return $this->response->withJson($customerpackageDetails);
    });
   
   
   