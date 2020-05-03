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

<div class="row center-block">
    <div class="col s7">
        <h3>Goal of this website:</h3>
        <p>The purpose of this websystem is to give to user a readable list of selected RSS feeds.
        Administrators can add or delete websites from the list to restrain or improve the feed selection.
        They can also change the number of news displayed per page and they can also refresh the feed manually.</p>
    </div>
</div>

<div class="row center-block">
    <div class="col s7 offset-s3">
        <div class="col s4"><image src="view/Images/materialize_logo.png" alt="Phpmyadmin logo"></image></div>
        <div class="col s6"><h3>MaterializeCss</h3></div>
        <p><a href="https://materializecss.com/">Materialize CSS</a> is a library that allows for visually appealing designs for websites.
        It is easy to use and follows standards to give consistent design to web applications.</p>
    </div>
</div>

<div class="row center-block">
    <div class="col s7">
        <div class="col s4"><image src="view/Images/AWS_logo.png" alt="Phpmyadmin logo"></image></div>
        <div class="col s6"><h3>AWS EC2</h3></div>
        <p><a href="https://aws.amazon.com/">Amazon Web Service</a> is a powerful platform specialised in on demand cloud computing services. AWS offers APIs, Databases, Virtual machines, etc... 
        Amazon web services where used on the project for the hosting part of the website to make it accessible from everywhere. </p>
    </div>
</div>

<div class="row center-block">
    <div class="col s7">
        <div class="col s4"><image src="view/Images/phpmyadmin_logo.png" alt="Phpmyadmin logo"></image></div>
        <div class="col s6"><h3>Phpmyadmin</h3></div>
        <p><a href="https://www.phpmyadmin.net/">Phpmyadmin</a> is a free software tool that allows to handle the administration of MySQL over the Web.
        phpMyAdmin supports a wide range of operations on MySQL and MariaDB and offers a practical user interface to perform operations on a DB.</p>
    </div>
</div>
