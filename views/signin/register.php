<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Register</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="inputLoginR" class="control-label">Login</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Login" value="<?php if(isset($_POST["login"])) echo $_POST["login"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="inputPasswordR" class="control-label">Password</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="inputPasswordRC" class="control-label">Password</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPasswordC" name="password_c" placeholder="Password" value="<?php if(isset($_POST["password_c"])) echo $_POST["password_c"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="register" class="btn btn-default">Register</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>