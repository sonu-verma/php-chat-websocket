<?php
   include "../init.php";

   if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $search = trim(stripcslashes(htmlentities($_POST['search'], ENT_QUOTES)));
       $userList = $userObj->usersList($search);
       if($userList){
           foreach($userList as $user){
               $imgUrl = 'assets/images/defaultImage.png';
               if($user->profileImg){
                   $imgUrl = BASE_URL.'images/users/'.$user->profileImg;
               }
               ?>
               <li class="flex select-none items-center
           cursor-pointer rounded-lg p-3">
                   <a href="<?php echo BASE_URL.$user->username; ?>/messages" class="flex-1">
                       <div class="flex-1 flex">
                           <div class="flex gap-x-2 items-center flex-1 flex-wrap ">
                               <div>
                                   <img class="w-12 h-12 object-cover border-gray-400 border rounded-full" src="<?php echo $imgUrl; ?>"/>
                               </div>
                               <div class="flex">
                                   <div>
                                       <div class="text-gray-800">
                        <span style="font-size: .9375rem;">
                        	<?php echo $user->username; ?>
                        </span>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </a>
               </li>
                <?php
           }
       }else{
           echo "<p>No Result Found</p>";
       }
   }