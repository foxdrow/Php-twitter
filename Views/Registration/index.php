<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../Views/Registration/style.css">
    <title>Twitter-Registration</title>
</head>
<body>
    <div class="d-flex align-items-center flex-column justify-content-center h-100 text-white">
        <div class="card bg-light">
            <div class="card-body">
                <h1 class="display-4 text-primary">Hello.</h1>
                <form action="./Users/registration" method="post">
                    <div class="form-group" id="input-text">
                        <input class="form-control transparent-input my-1" id="nickname" name="nickname" placeholder="Nickname" type="text" required>
                        <input class="form-control transparent-input my-1" id="password" name="password" placeholder="Password" type="password" required>
                        <input class="form-control transparent-input my-1" id="password" name="password_verif" placeholder="Password" type="password" required>
                        <input class="form-control transparent-input my-1" id="password" name="email" placeholder="email" type="email" required>
                        <p class="text-secondary mt-3 mb-0">Date of birth</p>
                        <input type="date" name="birthday" required>                   
                    </div>
                    <div id="btn-registration" class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Go to twitter</a></button>
                    </div>
                    <p class="text-secondary">ALREADY HAVE AN ACCOUNT? <a href="./Users/connectionPage">LOG IN</a></p>
                </form>
            </div>
        </div>
    </div>
            
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</body>
</html>