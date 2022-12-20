<?php

    class Messenger{
        public $db,$user,$userID,$common;

        public function __construct(){
            $db = new DB;
            $this->db = $db->connect();
            $this->user = new User();
            $this->userID = $this->user->userID();
            $this->common = new Common();
        }

        public function redirectToMessage(){
            $sql = "SELECT * FROM `messages` LEFT JOIN users on sentTo = userID
                        WHERE sentTo = userID AND sentBy = :userID
                        ORDER BY messageID DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":userID",$this->userID,PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            if($user){
                $this->common->redirect("{$user->username}/messages");
            }elseif(!basename(__FILE__) == 'home.php'){
                $this->common->redirect('home.php');
            }
        }

        public function getRecentMessages(){
            $sql = "SELECT *,messages.created_at as messageDate  FROM `messages` 
                    INNER JOIN `users` on `sentBy` = `userID` and 
                        `messageID` in   (
                                            SELECT MAX(`messageID`) FROM messages 
                                                        WHERE `sentBy` = `userID` AND `sentTo` = :userID OR 
                                                            `sentBy` = :userID AND `sentTo` = userID 
                                        ) OR `sentTo` = 'userID' AND 
                        `messageID` in (
                                            SELECT MAX(`messageID`) from messages
                                                WHERE `sentBy` = `userID` AND `sentTo` = :userID OR 
                                                 `sentBy` = :userID AND `sentTo` = userID 
                                        )
                    WHERE `sentBy` = `userID` AND `sentTo` = :userID OR 
                          `sentBy` = :userID AND `sentTo` = userID ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":userID",$this->userID,PDO::PARAM_INT);
            $stmt->execute();
            $messages =  $stmt->fetchAll(PDO::FETCH_OBJ);
            if($messages){
                foreach($messages as $user){
                    $date  = new DateTime($user->messageDate);
                    $profileImg = BASE_URL.'assets/images/defaultImage.png';
                    if($user->profileImg){
                        $profileImg = BASE_URL."assets/images/users/".$user->profileImg;
                    }
                echo '<li id="recent" 
                        class="'.(($user->status == 'notseen') ? 'fb-li-active' : '').' overflow-hidden 
                               flex select-none items-center
                               cursor-pointer rounded-lg p-3">
                            <a class="flex-1" 
                               href="'.BASE_URL.$user->username.'/messages">
                            <div class="flex-1 flex">
                                <div class="flex relative 
                                            gap-x-2 items-center 
                                            flex-1 flex-wrap">
                                    <div class="flex-shrink-0">
                                        <img class="w-12 h-12 object-cover 
                                                    border-gray-400 border 
                                                    rounded-full" 
                                             src="'.$profileImg.'">
                                    </div>
                                    <div class="flex overflow-hidden">
                                        <div class="mx-auto"> 
                                         
                                          <div class="text-gray-800">		
                                            <span style="font-size: .9375rem;">
                                            '.$user->username.'
                                          </div>
                    
                                            <div class="text-gray-500 text-xs mx-auto flex">
                                                <div><span class="text-xs">'.$user->message.'</span></div>
                                                <div class="time-stamp text-gray-500 
                                                            text-xs self-end mx-1 mx-2">
                                                    <span class="self-start tracking-wide">'.$date->format("h:i a").'</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    '.(($user->status === 'notseen')?'<span id="badge" 
                                           class="fb-color absolute right-1">
                                           <i class="fas fa-circle"></i>
                                     </span>':'').'
                                </div>
                            </div>
                        </a>
                    </li>';
                }
            }else{
                echo "No recent messages";
            }
        }

        public function getChat($senderID){
            $stmt = $this->db->prepare("SELECT * FROM `messages` 
                                                LEFT JOIN `users` on `sentBy` = `userID`
                                                WHERE `sentBy` = :senderID  AND `sentTo` = :userID OR
                                                       `sentTo` = :senderID AND `sentBy` = :userID
                                                       ORDER BY  `messageID` DESC");
            $stmt->bindParam(":senderID",$senderID,PDO::PARAM_INT);
            $stmt->bindParam(":userID", $this->userID,PDO::PARAM_INT);
            $stmt->execute();
            $chats =  $stmt->fetchAll(PDO::FETCH_OBJ);
            foreach($chats as $chat){
                $profileImg = "";
                if(!$chat->profileImg){
                    $profileImg = BASE_URL."assets/images/defaultImage.png";
                }else{
                    $profileImg = BASE_URL."assets/images/users/".$chat->profileImg;
                }
                if($chat->sentBy == $this->userID){
                    echo '<!-- RIGHT SIDE MESSAGE -->
                            <div class="message flex w-full h-auto justify-end">
                                <div class="flex flex-row-reverse">
                                    <div class="flex items-center">
                                       <span 
                                            class="fb-bg text-white
                                                   py-2 px-4 m-1 
                                                   rounded-full 
                                                   text-sm">'.$chat->message.'
                                       </span>
                            
                                    </div>
                                    <div class="flex items-center">
                                        <div>
                                            <ul class="flex gap-x-1 text-gray-400 
                                                       text-sm hidden">
                            
                                                <li class="leading-6 hover:bg-gray-100 
                                                           text-center rounded-full 
                                                           w-6 h-6 
                                                           cursor-pointer">
                                                    <span><i class="fas fa-ellipsis-v"></i></span>
                                                </li>
                                                
                                                <li class="leading-6 hover:bg-gray-100 
                                                           text-center rounded-full 
                                                           w-6 h-6 cursor-pointer">
                                                    <span><i class="p-1 fas fa-reply"></i></span>
                                                </li>
                            
                                                <li class="leading-6 hover:bg-gray-100 
                                                           text-center rounded-full 
                                                           w-6 h-6 cursor-pointer">
                                                    <span><i class="p-1 far fa-smile"></i></span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }else{
                    echo '<div class="message flex w-full">
                            <div class="flex items-end">
                                <div class="px-1 py-1">
                                    <img class="w-8 h-8 object-cover border-gray-400 
                                                border rounded-full" 
                                         src="'.$profileImg.'"/>
                                </div>
                                <div class="flex items-center max-w-xs">
                                   <span class="rounded-2xl bg-gray-200 
                                                text-gray-800 text-white 
                                                py-2 px-4 m-1 
                                                rounded-full text-sm">'.$chat->message.'</span>
                                </div>
                                <div class="flex self-center hover:flex">
                                    <div>
                                        <ul class="flex gap-x-1 text-gray-400 
                                                   text-sm flex-row-reverse hidden">
                                            <li class="leading-6 hover:bg-gray-100 
                                                       text-center rounded-full 
                                                       w-6 h-6 cursor-pointer">
                                             <span><i class="fas fa-ellipsis-v"></i></span>
                                            </li>
                        
                                            <li class="leading-6 hover:bg-gray-100 
                                                       text-center rounded-full 
                                                       w-6 h-6 cursor-pointer">
                                             <span><i class="p-1 fas fa-reply"></i></span>
                                            </li>
                                            
                                            <li class="leading-6 hover:bg-gray-100 
                                                       text-center rounded-full 
                                                       w-6 h-6 cursor-pointer">
                                                <span><i class="p-1 far fa-smile"></i></span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            }
        }
    }