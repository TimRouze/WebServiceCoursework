<nav>
  <div class="nav-wrapper">
    <a href="" class="brand-logo">Nebulae flux</a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
      <?php if($this->currentAdminName != null){ ?>
        <li>
            <t>Connected as : <?php echo $this->currentAdminName ?></t>
        </li>
        <li>
            <form id="adminDisconnect" method="POST" action="index.php">

                <input type='hidden' name="action" value='adminDisconnect'/>
                <a href="#" onclick="document.getElementById('adminDisconnect').submit()">Disconnect</a>
            </form>
        </li>
      <?php } ?>
      <li>
        <form id="adminConnect" method="POST" action="index.php">
            <input type='hidden' name="action" value='goAdmin'/>
            <a href="#" onclick="document.getElementById('adminConnect').submit()">Go Admin page</a>
        </form>
      </li>
      <li>
        <form id="backToNews" method="POST" action="index.php">
            <input type='hidden' name="action" value=''/>
            <a href="#" onclick="document.getElementById('backToNews').submit()">Go back to News</a>
        </form>>
      </li>
    </ul>
  </div>
</nav>