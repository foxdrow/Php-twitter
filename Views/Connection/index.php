<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="../Style/style.css">
    <link rel="stylesheet" href="../Views/Connection/style.css">
    <title>Twitter - Connection</title>
</head>
<body>
    <div class="d-flex align-items-center flex-column justify-content-center h-100 text-white" id="header">
        <div class="card bg-light">
            <div class="card-body">    
                <h1 class="display-4 text-primary">Glad to see you again.</h1>
                <form method="post" action="./userConnection">
                    <div class="form-group" id="input-text">
                        <input class="form-control transparent-input form-control-lg my-1" id='email' name='email' placeholder="Email" type="email" required>
                        <input class="form-control transparent-input form-control-lg my-1" id='password' name='password' placeholder="Password" type="password" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
                    </div>
                    <p class="text-secondary">NEW TO TWITTER? <a href="./">SIGN UP</a></p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
</body>
</html>