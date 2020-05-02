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