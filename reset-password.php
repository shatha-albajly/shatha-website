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
    <h2 class="text-center py-4">Reset password</h2>
    <p>enter your email or phone number (ony one)</p>
    <div class="conatiner flex justify-content-center align-items-center ">
        <form onsubmit="event.preventDefault(); resetPassword();" method="POST" class="shadow  bg-body rounded form">

            <div class="form-group my-2">
                <label for="email">Email or phone:</label>
                <input type="text" class="form-control" name='email' id="email" aria-describedby="emailHelp"
                    placeholder="Enter email" required >
            </div>

           


            <button type="submit" class="btn w-100 my-2 btn-primary">Submit</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>