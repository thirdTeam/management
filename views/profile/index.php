<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Profile</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" action="./index.php?controller=profile&action=changeInfo">
                            <div class="form-group">
                                <label class="control-label" for="name">Name</label>
                                <input class="form-control" id="name" placeholder="Enter name" type="text" name="name" value="<?php echo $user_data['name'];?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="surname">Surname</label>
                                <input class="form-control" id="surname" placeholder="Enter surname" type="text" name="surname" value="<?php echo $user_data['surname']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="surname">Company</label>
                                <input class="form-control" id="surname" placeholder="Enter surname" type="text" name="company" value="<?php echo $user_data['company']; ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="email">Email address</label>
                                <input class="form-control" id="email" placeholder="Enter email" type="email" name="email" value="<?php echo $user_data['email']; ?>">
                            </div>
                            <button type="submit" class="btn btn-default" name="change_info">Change</button>
                        </form>
                        <hr/>
                        <form role="form" method="post" action="./index.php?controller=profile&action=changeAds">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Your ads:</h3></div>
                                <?php if ($_SESSION["user_ads_count"] > 0){ ?>
                                <table class="table">
                                    <tr><th>#</th><th>Profession</th><th>Updated</th><th>Update It?</th><th>Delete It?</th><th>Click to Show</th></tr>
                                    <?php
                                        for($i = 0; $i < $_SESSION["user_ads_count"]; $i++){
                                            $ad = $adlist[$i];
                                            $_SESSION["ad_".$i] = $ad["id"];
                                            require("views/ads/profile_ad.php");
                                        } ?>
                                </table>
                                <?php } else { ?>
                                    <div class="panel-body">
                                        No ads...
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-default" name="change_ads">Change</button>
                        </form>
                        <form role="form" method="post" action="./index.php?controller=profile&action=changeSub">
                            <div class="panel panel-default">
                                <div class="panel-heading"><h3 class="panel-title">Your subscribes:</h3></div>
                                <?php if ($_SESSION["user_sub_count"] > 0){ ?>
                                    <table class="table">
                                        <tr><th>#</th><th>Profession</th><th>City</th><th>Salary</th><th>Unsubscribe</th></tr>
                                        <?php
                                        for($i = 0; $i < $_SESSION["user_sub_count"]; $i++){
                                            $sub = $sublist[$i];
                                            $_SESSION["sub_".$i] = $sub["id"];
                                            require("views/profile/subscribes.php");
                                        } ?>
                                    </table>
                                <?php } else { ?>
                                    <div class="panel-body">
                                        No subscribes...
                                    </div>
                                <?php } ?>
                            </div>
                            <button type="submit" class="btn btn-default" name="change_sub">Change</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>