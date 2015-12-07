<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Your vacancy:</h1>
                <form role="form" method="post" action="./index.php?controller=create&action=add">
                    <div class="form-group">
                        <label class="control-label" for="profession">Profession</label>
                        <input class="form-control" id="profession" placeholder="Enter profession" type="text" name="profession" value="<?php if(isset($_POST["profession"])) echo $_POST["profession"]; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="city">City</label>
                        <input class="form-control" id="city" placeholder="Enter city" type="text" name="city" value="<?php if(isset($_POST["city"])) echo $_POST["city"]; ?>">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="city">Salary</label>
                        <input class="form-control" id="city" placeholder="Enter city" type="text" name="salary" value="<?php if(isset($_POST["salary"])) echo $_POST["salary"]; ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea class="form-control" rows="5" id="description" name="description"><?php if(isset($_POST["description"])) echo $_POST["description"]; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-default" name="add">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>