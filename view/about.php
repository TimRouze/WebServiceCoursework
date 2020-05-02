<nav>
  <div class="nav-wrapper">
    <a href="" class="brand-logo">Nebulae flux</a>
    <ul id="nav-mobile" class="right hide-on-med-and-down">
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

<div class="row">
    <div class="col s6">
        <h3>Goal of this website:</h3>
        <p>The purpose of this websystem is to give to user a readable list of selected RSS feeds.
        Administrators can add or delete websites from the list to restrain or improve the feed selection.
        They can also change the number of news displayed per page and they can also refresh the feed manually.</p>
    </div>
</div>