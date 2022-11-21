<?php
    require 'core/init.php';
    $commonObj->isLoggedIn();
//    $data = $commonObj->getTableData('users');
//    var_dump($data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Facebook Messenger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="BASE_URLassets/style/style.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.css" rel="stylesheet"/>
    <script>
        var siteUrl = "<?php echo BASE_URL; ?>";
    </script>
</head>
<body>
<div class="wrapper">
    <div class="inner-wrapper">
        <div class="w-screen h-screen">
            <!--Wrapper for chat-->
            <div class="flex h-full flex-wrap flex-auto">
                <!--CHAT_LEFT-->
                <div class="chat-left w-1/5">
                    <div class="flex flex-col">
                        <div class="flex mx-4 flex-wrap">
                            <div class="flex-1">
                                <h3 class="select-none font-bold text-2xl text-gray-800 py-4">Chats</h3>
                            </div>
                            <div class="flex items-center flex-wrap">
                            <span class="rounded-full w-8 h-8 bg-gray-200 flex items-center justify-center p-4 m-1 cursor-pointer">
                                <i class="fas fa-ellipsis-h"></i>
                            </span>
                                <span class="rounded-full w-8 h-8 bg-gray-200 flex items-center justify-center p-4 m-1 cursor-pointer">
                                <i class="fas fa-video"></i>
                            </span>
                                <span class="rounded-full w-8 h-8 bg-gray-200 flex items-center justify-center p-4 m-1 cursor-pointer">
                                <i class="far fa-edit"></i>
                            </span>
                            </div>
                        </div>
                        <div class="flex bg-gray-100 m-2 mx-4 rounded-full border items-center">
                            <span class="text-gray-500 px-1 pl-2 text-xl"><i class="fas fa-search"></i></span>
                            <span class="flex-1 p-1"><input id="search" class="w-full outline-none bg-transparent text-gray-700" type="text" placeholder="Search for User" name="user-search" /></span>
                        </div>
                        <div>
                            <div>
                                <ul class="mx-2 left-overflow flex-wrap">
                                    <div class="result hidden">

                                    </div>
                                    <div id="recentMessages">
                                        <!-- RECENT-MESSAGES -->
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div><!--CHAT_LEFT_ENDS-->
                <!--CHAT_CENTER-->
                <div class="chat-center flex-1 flex flex-col h-full border border-gray-300 border-t-0 border-b-0">
                    <div class="flex items-center justify-between border border-l-0 border-r-0 border-b-1 border-t-0 border-gray-300">
                        <div class="items-center flex">
                            <div class="px-3 py-4">
                                <img src="<?php echo BASE_URL.'assets/images/defaultImage.png'; ?>" class="w-10 h-10 object-cover border-gray-400 border rounded-full"/>
                            </div>
                            <div>
                            <span class="select-none font-bold text-gray-800 text-lg ">
                                <a href="#" class="hover:underline"> </a>
                            </span>
                            </div>
                            <div>
                                <span class="bg-blue-300 rounded-full inline-block"></span>
                            </div>
                        </div>
                        <div class="gap-x-4 flex mx-4 text-xl fb-color">
                            <form method="POST" action="<?php echo BASE_URL; ?>logout.php">
                                <button type="submit">
                                    (<?php echo $userData->username; ?>)Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <div id="chat" class="chat-wrap h-full flex overflow-y-auto">
                        <!--CHAT-->
                        <div id="messages" class="chat p-2 flex flex-col-reverse overflow-y-auto w-full">

                        </div>
                        <!--CHAT_ENDS-->
                    </div>
                    <!--CHAT_WRAP_ENDS-->
                    <div class="box-border border-gray-300 border py-3 px-3 border-l-0 border-r-0">
                        <ul class="gap-x-1 flex items-center justify-arround text-white text-lg">
                            <li class="m-1 cursor-pointer ">
                            <span>
                                <label for="file" class="cursor-pointer">
                                    <i class="text-xl fb-color p-1 p-1  far fa-images"></i>
                                </label>
                             </span>
                            </li>
                            <li class="flex-1 m-1 cursor-pointer relative text-gray-700 bg-gray-100 py-2 px-4 flex-1 w-full border-gray-300 rounded-full ">
                                <input class="outline-none  placeholder-gray-300::placeholder bg-transparent w-full" placeholder="Enter Your Message" type="text" name="message" autocomplete="no">
                            </li>
                            <li class="self-center flex cursor-pointer ">
                            <span class="text-lg text-gray-400 text-2xl">
                                <i class="fb-color fas fa-thumbs-up"></i>
                            </span>
                            </li>
                        </ul>
                    </div>
                </div><!--CHAT_CENTER_ENDS-->
                <!--CHAT_RIGHT-->
            </div><!--Wrapper for chat-ends-->
        </div>
    </div><!----INNER_WRAPPER---->
</div><!----WRAPPER ENDSS--->
<script src="<?php echo BASE_URL; ?>assets/js/search.js"></script>
</body>
</html>
