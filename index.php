<?php
    require 'core/init.php';
    //    Register User

//    $lastInsertedId = $commonObj->insertData('users',['username' => 'Sam','email' => 'sam@gmail.com','password' => $commonObj->hashPassword('password'),'sessionID' => 'abc','connectionID' => 0]);


    // Check login functionality
    $error = "";
    $oldEmail = "";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if(empty($email) || empty($password)){
            $oldEmail = $_POST['email'];
            $error = 'Please enter credentials for login.';
        }else{
            $oldEmail = $_POST['email'];
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $oldEmail = $_POST['email'];
                $error = "Please enter valid email id.";
            }
            $user = $userObj->emailExist($email);
            if($user){
                if(password_verify($password,$user->password)){
                    $_SESSION['isLoggedIn'] = true;
                    $_SESSION['user_id'] = $user->userID;
                    $commonObj->redirect('home.php');
                }else{
                    $error = "Invalid credentials, please try again.";
                }
            }else{
                $error = "Invalid credentials, please try again.";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Facebook Messenger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="assets/style/style.css">
</head>
<body>
<div class="wrapper">
    <div class="inner-wrapper">
        <!--WRAPPER FOR LOGIN-->
        <div class="flex h-screen w-screen justify-center">
            <div class="h-4/5 w-full flex fb-body-bg">
                <div class="flex items-center flex-1">
                    <div class="flex mx-auto" style="width: 980px;">
                        <div class="flex-col flex p-2 pt-16">
                            <div>
                                <h1 class="font-bold fb-color text-6xl">facebook</h1>
                            </div>
                            <div>
                                <h2 class="text-gray-700 text-4xl">Facebook helps you connect and share with the people in your life.</h2>
                            </div>
                        </div>
                        <div style="width: 396px;" class="shadow-md bg-white rounded-xl border border-gray-100 mx-2">
                            <div>
                                <div class="mx-1 my-1 p-2">
                                    <ul class="flex flex-col">
                                        <form method="POST">
                                            <li class="m-1 my-2">
                                                <input  type="Email"
                                                        name="email"
                                                        placeholder="Email address or phone number"
                                                        class="login-input"
                                                        value="<?php echo $oldEmail; ?>"
                                                >
                                            </li>
                                            <li class="m-1 my-2">
                                                <input  type="password"
                                                        name="password"
                                                        placeholder="Password"
                                                        class="login-input"
                                                >
                                            </li>
                                            <?php if(!empty($error)){ ?>
                                            <li class="m-1 my-2">
                                                <p class="text-red-400 text-sm"><?php echo $error; ?></p>
                                            </li>
                                            <?php } ?>
                                            <li class="m-1 my-2">
                                                <button class="text-lg py-2 px-5 fb-bg text-white w-full rounded-lg font-bold">Log In</button>
                                            </li>
                                            <li class="m-1 my-2 text-center">
                                                <a href="#" class="fb-color text-sm">Forgot password</a>
                                            </li>
                                            <li class="m-1 my-2 border-t border-gray-200"></li>
                                        </form>
                                        <li class="m-1 my-2 text-center">
                                            <button class="text-lg py-2 px-5 fb-green text-white rounded-lg font-bold">Create New Account</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--WRAPPER FOR LOGIN-END-->
    </div><!----INNER_WRAPPER---->
</div><!----WRAPPER ENDSS--->
</body>
</html>
