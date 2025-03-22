<form action="handle_add_product" method="POST">
    <div class="container">
        <br> <a href="/catalog">Каталог</a> <br>
        <br> <a href="/cart">Корзина</a>
        <h1>Add product</h1>

        <?php if (isset($message)): ?>
            <p><?php echo $message;?></p>
        <?php else: ?>
        <p>Please fill in this form.</p>
            <?php endif; ?>
        <hr>

        <label for="product_id"><b>Product_id</b></label>
        <?php if (isset($errors['product_id'])): ?>
            <label style="color:red" ><?php echo $errors['product_id'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter product_id" name="product_id" id="product_id" required>


        <label for="amount"><b>Amount</b></label>
        <?php if (isset($errors['amount'])): ?>
            <label style="color: red"><?php echo $errors['amount'];?></label>
        <?php endif; ?>
        <input type="text" placeholder="Enter amount" name="amount" id="amount" required>


        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Add product</button>
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