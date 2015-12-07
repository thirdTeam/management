<div class="navbar navbar-default navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="./index.php?controller=pages&action=home"><span>Third Team Site</span></a>
    </div>
    <div class="collapse navbar-collapse" id="navbar-ex-collapse">
      <ul class="nav navbar-nav navbar-right">
        <li <?php echo ($controller === 'pages')?'class="active"':''; ?>>
          <a href="./index.php?controller=pages&action=home">Home</a>
        </li>
        <li <?php echo ($controller === 'search')?'class="active"':''; ?>>
          <a href="./index.php?controller=search&action=index">Search</a>
        </li>
        <li <?php echo ($controller === 'create')?'class="active"':''; ?>>
          <a href="./index.php?controller=create&action=index">Create</a>
        </li>
        <?php if($auth){?>
          <li <?php echo ($controller === 'profile')?'class="active"':''; ?>>
            <a href="./index.php?controller=profile&action=index">Profile</a>
          </li>
          <li>
            <a href="./index.php?controller=profile&action=logout">Logout</a>
          </li>
        <?php } else { ?>
        <li <?php echo ($controller === 'signin')?'class="active"':''; ?>>
          <a href="./index.php?controller=signin&action=index">Sign In</a>
        </li>
        <?php }?>
      </ul>
    </div>
  </div>
</div>