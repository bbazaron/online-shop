<?php session_start();?>
<form action="handle-change-data" method="POST">
    <div class="container">
        <a href="/profile">Мой профиль</a> <br><br>
        <a href="/add-product">Добавить продукты</a> <br><br>
        <a href="/cart">Корзина</a>
        <h1>Change data</h1>
        <p>Please enter the new data.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <?php if (isset($errors['name'])): ?>
            <label style="color:red" ><?php echo $errors['name'];?></label>
        <?php endif; ?>

        <?php

        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT name FROM users WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['userId']]);
        $name = $stmt->fetchColumn();
        ?>
        <input type="text" placeholder="<?php echo $name;?>" name="name" id="name" required>


        <label for="psw"><b>Password</b></label>
        <?php if (isset($errors['password'])): ?>
            <label style="color: red"><?php echo $errors['password'];?></label>
        <?php endif; ?>
        <input type="password" placeholder="Enter New Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php if (isset($errors['psw-repeat'])): ?>
            <label style="color: red"><?php echo $errors['psw-repeat'];?></label>
        <?php endif; ?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>

        <label for="psw-repeat"><b>Add profile picture</b></label>
        <?php if (isset($errors['psw-repeat'])): ?>
            <label style="color: red"><?php echo $errors['psw-repeat'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="Add URL" name="avatar" id="avatar" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Change</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
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
</style>