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
        <form id="goAbout" method="POST" action="index.php">
          <input type='hidden' name="action" value='aboutPage'/>
          <a href="#" onclick="document.getElementById('goAbout').submit()">About</a>
          <i class="small material-icons">info_outline</i>
        </form>
      </li>
    </ul>
  </div>
</nav>

<table class="z-depth-3 bordered highlight responsive-table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Site</th>
      <th>Title</th>
      <th>Description</th>
    </tr>
  </thead>

  <tbody>
    <?php
      foreach($this->news as $new){
        echo"
          <tr>
            <td>".$new->getDate()."</td>
            <td><a target=\"_blank\" href=\"".$new->getWebsiteUrl()."\" > ".$new->getSiteName()."</a></td>
            <td><a target=\"_blank\" href=\"".$new->getUrl()."\" > ".$new->getTitle()."</a></td>
            <td class='collapsible popout' data-collapsible='accordion'>
              <li style='list-style-type:none'>
                <div class='collapsible-header'>".substr($new->getDescription(), 0, 50)."...</div>
                <div class='collapsible-body'>
                ".$new->getDescription()."
                </div>
              </li>
            </td>
          </tr>
        ";
      }
    ?>
  </tbody>
</table>

<div style="">
  <ul class="pagination center-align">
      <?php
        foreach($this->pages  as $page){
          $active = $page == $this->currentPage ? 'active' : '';

          echo "<li class=".$active."><a href='index.php?p=".$page."'>".$page."</a></li>";
        }
      ?>
  </ul>
</div>


