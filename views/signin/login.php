<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Login</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="post">
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="inputLogin" class="control-label">Login</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Login" value="<?php if(isset($_POST["login"])) echo $_POST["login"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2">
                                    <label for="inputPassword" class="control-label">Password</label>
                                </div>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" value="<?php if(isset($_POST["password"])) echo $_POST["password"]; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="signin" class="btn btn-default">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>