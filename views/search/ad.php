<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4><?php echo $ad->position?></h4>
        </div>
        <div class="panel-body">
            <h5><?php echo $ad->region?></h5>
            <?php echo $ad->description?>
            <h5><?php echo $ad->salary?></h5>
            <h5><?php echo $ad->lastupdated?></h5>
            <div class="col-md-3 col-md-offset-9">
                <a class="btn btn-default" href="<?php echo $ad->url ?>" role="button">Go To</a>
            </div>
        </div>
    </div>
</div>