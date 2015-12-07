<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4><?php echo $ad["profession"]; ?></h4>
                        </div>
                        <div class="panel-body">
                            <h5><?php echo $ad["city"]; ?></h5>
                            <?php echo nl2br($ad["description"]); ?>
                            <?php if(!empty($ad["salary"])) echo "<h5>".$ad["salary"]." грн.</h5>"; ?>
                            <h5><?php echo $this->getLastUpdate($ad["updated"])." дней назад"; ?></h5>
                            <hr>
                            <h5>Add form: <?php echo $ad["name"]." ".$ad["surname"].", ".$ad["company"]; ?></h5>
                            <h5>Email: <?php echo $ad["email"]; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>