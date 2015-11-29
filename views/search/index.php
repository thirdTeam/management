<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="jumbotron text-center" style="background:transparent !important">
                    <h1>Search</h1>
                    <p>Fill fields below and press "Find"</p>
                    <form class="form-horizontal" role="form" method="post" action="./index.php?controller=search&action=result&page=1">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="profession">Profession:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="profession" name="profession" placeholder="Enter profession">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="city">City:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="age">Age:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="age" name="age" placeholder="Enter age">
                            </div>
                            <label class="control-label col-sm-2" for="salary">Salary:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="salary" name="salary" placeholder="Enter salary">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-4">
                                <button type="submit" name="find" class="btn btn-default btn-block">Find</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>