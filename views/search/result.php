<div class="section">
    <div class="container">
        <form role="form">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="row">
                        <h1>Search results:</h1>
                    </div>
                    <?php
                        for($i = 0; $i < $ads_to_show; $i++){
                            $ad = $_SESSION["ad_list"][$start + $i];
                            require("views/search/ad.php");
                        }
                    ?>
                </div>
            </div>
            <ul class="pager">
                <?php if($page != 1){?>
                <li>
                    <a href="<?php echo './index.php?controller=search&action=result&page='.($page - 1); ?>">Previous</a>
                </li>
                <?php } echo $page; if($page != $_SESSION["last_page"]) {?>
                <li>
                    <a href="<?php echo './index.php?controller=search&action=result&page='.($page + 1); ?>">Next</a>
                </li>
                <?php;} ?>
            </ul>
            <div class="col-md-6 col-md-offset-3">
                <button type="button" class="btn btn-default btn-block">Subscribe for results</button>
            </div>
        </form>
    </div>
</div>