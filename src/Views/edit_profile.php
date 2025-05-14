<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location:/login");
    exit;
}

$user = \Model\User::getBySessionId($_SESSION['userId']);

?>
<form action="editProfile" method="POST">
    <div class="container">
        <a href="/catalog" class="btn btn-catalog">
            <i class="fas fa-list"></i> Каталог
        </a>

        <a href="/profile" class="btn btn-profile">
            <i class="fas fa-user"></i> Профиль
        </a>

        <a href="/orders" class="btn btn-orders">
            <i class="fas fa-clipboard-list"></i> Мои заказы
        </a>

        <a href="/cart" class="btn btn-cart">
            <i class="fas fa-shopping-cart"></i> Корзина
            <span class="cart-badge"><?php echo $cartQuantity;?></span>
            <span class="cart-total"><?php echo $sum;?> ₽</span>
        </a>

        <h1>Edit profile</h1>
        <p>Please enter the new data.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <?php if (isset($errors['name'])): ?>
            <label style="color:red" ><?php echo $errors['name'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="<?php echo $user->getName();?>" name = "name" value="<?php echo $user->getName();?>" id="name">

        <label for="psw"><b>Email</b></label>
        <?php if (isset($errors['email'])): ?>
            <label style="color: red"><?php echo $errors['email'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="<?php echo $user->getEmail();?>" name="email" value="<?php echo $user->getEmail();?>" id="email">

        <label for="psw"><b>Password</b></label>
        <?php if (isset($errors['password'])): ?>
            <label style="color: red"><?php echo $errors['password'];?></label>
        <?php endif; ?>
        <input type="password" placeholder="Enter New Password" name="psw" id="psw" >

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php if (isset($errors['psw-repeat'])): ?>
            <label style="color: red"><?php echo $errors['psw-repeat'];?></label>
        <?php endif; ?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" >

        <label for="psw-repeat"><b>Add profile picture</b></label>
        <?php if (isset($errors['psw-repeat'])): ?>
            <label style="color: red"><?php echo $errors['psw-repeat'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="Add URL" name="avatar" id="avatar" >
        <hr>

        <button type="submit" class="registerbtn">Change</button>
    </div>


</form>

<style>
    :root {
        --primary-color: #4a6bff;
        --secondary-color: #ff6b6b;
        --dark-color: #2c3e50;
        --light-color: #f8f9fa;
    }

    body {
        font-style: sans-serif;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: none;
        outline: none;
    }

    .btn-catalog {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-catalog:hover {
        background-color: #3a5bef;
    }

    .btn-profile {
        background-color: var(--dark-color);
        color: white;
    }

    .btn-profile:hover {
        background-color: #1a2b3c;
    }

    .btn-orders {
        background-color: #6c5ce7;
        color: white;
    }

    .btn-orders:hover {
        background-color: #5d4aec;
    }

    .btn-cart {
        position: relative;
        background-color: var(--secondary-color);
        color: white;
        padding-right: 45px;
    }

    .btn-cart:hover {
        background-color: #ff5252;
    }

    .cart-badge {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background-color: white;
        color: var(--secondary-color);
        border-radius: 10px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: bold;
        min-width: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .cart-total {
        margin-left: 5px;
        font-size: 12px;
        opacity: 0.9;
    }
</style>