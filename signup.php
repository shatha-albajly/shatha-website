<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Managment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="scripts.js"></script>


</head>

<body>
    <h2 class="text-center py-4">Signup</h2>
    <form onsubmit="event.preventDefault(); signup();" method="POST" class=" container shadow  bg-body rounded form">
        <div class="form-group my-2">
            <label for="username">Username:</label>
            <input name="username" required type="text" name="username" class="form-control" id="username"
                aria-describedby="emailHelp" placeholder="Enter Name" >
        </div>
        <div class="form-group my-2">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                placeholder="Enter email" required >
        </div>
        <div class="form-group my-2">
            <label for="phone">Phone:</label>
            <input type="number" class="form-control" id="phone" name="phone" aria-describedby=""
                placeholder="Enter phone" required >
        </div>
        <div class="form-group my-2">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required
               >
        </div>
        <div class="form-group my-2">
            <label for="confirm-password">Conform Password:</label>
            <input type="password" class="form-control" name="confirm-password" id="confirm-password"
                placeholder="Re write password" required >
        </div>

        <button type="submit" class="btn w-100 my-2 btn-primary">Sign Up</button>

    </form>



</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>



</html>