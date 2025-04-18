
<form action="profile" method="POST">
    <div class="card">
        <div class="profile-container">
            <?php
            $userModel = new \Model\User();
            $userId=$_SESSION['userId'];
            $avatar = $userModel->getAvatarById($userId);
            ?>
            <img src="<?php echo $avatar->getAvatar();?>">

        </div>
        <div class="profile-info">
            <h1><?php echo $user->getName();?></h1>
            <p class="job-title"><?php echo $user->getEmail();?></p>
            <p class="job-title"><?php echo ('id = '.$user->getId());?></p>
        </div>
        <a href="/catalog">Каталог</a><a href="/orders">Мои заказы</a>
        <div class="profile-social">
            <button type="submit" class="registerbtn">Edit my profile</button>
        </div>
</form>

        <form action="/logout" method="POST">
        <button type="submit" class="registerbtn">Logout</button>
        </form>
        <div class="card-bottom"></div>
    </div>

    <style>@import url("https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Outfit", sans-serif;
        }

        .card {
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 8px;
            width: fit-content;
            border-radius: 16px;
            overflow: hidden;
            cursor: default;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            transform: 0.3s all ease-in-out;

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid white;
        }

        .card .profile-container {
            background-color: #9dbdff;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 40px;
            transition: 0.3s all ease-in-out;
        }

        .card .profile-info {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 0px 16px;
        }

        .card .profile-info h1 {
            font-size: 2rem;
            color: rgba(0, 0, 0, 0.7);
        }

        .card .profile-info .job-title {
            color: rgba(0, 0, 0, 0.5);
            font-weight: 700;
        }

        .card .profile-info .desc {
            color: rgba(0, 0, 0, 0.9);
            font-size: 0.9rem;
            max-width: 300px;
            margin-top: 8px;
        }

        .card .profile-social {
            display: flex;
            gap: 8px;
        }

        .card .profile-social a {
            color: #7695ff;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .card .profile-social a:hover {
            text-decoration: underline;
        }

        .card-bottom {
            width: 100%;
            background-color: #ff9874;
            height: 5px;
            transition: 0.3s all ease-in-out;
        }

        .card:hover .card-bottom {
            background-color: #ff6b6b;
        }

        .card:hover .profile-container {
            background-color: #7695ff;
        }
    </style>