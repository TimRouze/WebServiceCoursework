<script>

    <?php if(isset($this->newSiteName)){ ?>
        Materialize.toast('Site <?php echo $this->newSiteName ?> added !', 4000, 'rounded');
    <?php } ?>

    <?php if($this->siteDeleted){ ?>
        Materialize.toast('Site correctly deleted !', 4000, 'rounded');
    <?php } ?>
    
    <?php if(isset($this->numberOfNewsAdded)){ ?>
        Materialize.toast('<?php echo $this->numberOfNewsAdded ?> news added !', 4000, 'rounded');
    <?php } ?>


    function setRangeDefault(){
        document.getElementById("viewNumber").value = <?php echo $this->viewPerPage ?>;
    }

    function handleDeleteClick(siteId){
        var form = document.createElement("form");
        var action = document.createElement("input"); 
        var newValue = document.createElement("input"); 

        form.method = "POST";
        form.action = "index.php";   


        action.value="deleteSite";
        action.name="action";
        form.appendChild(action);


        newValue.value=siteId;
        newValue.name="siteId";
        form.appendChild(newValue);

        document.body.appendChild(form);

        form.submit();
    }
</script>

<nav>
    <div class="nav-wrapper teal lighten-2">
        <a class="brand-logo">Welcome <?php echo $this->currentAdminName ?></a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
                <form id="backToNews" method="POST" action="index.php">
                    <input type='hidden' name="action" value=''/>
                    <a href="#" onclick="document.getElementById('backToNews').submit()">Go back to News</a>
                </form>
            </li>
        </ul>
    </div>
</nav>

<div class="row">
    <form class="col s6 center-align" id="parseForm" method="POST" action="index.php">
        <h3>News Updater :</h3>
        <input type='hidden' name="action" value='newsUpdater'/>
        <a class="btn waves-effect waves-light" onclick="document.getElementById('parseForm').submit()">Update News</a>
    </form>
</div>

<div class="row">
    <h3>Add a new site :</h3>
    <form class="col s12" method="POST" action='index.php'>
        <div class="row">
            <div class="input-field col s6">
                <input class="<?php (isset($this->errors['siteName'])) ? print "invalid" : null ?>" name="siteName" id="siteName" type="text" class="validate">
                <label class="invalid" for="siteName">Website Name</label>
                <error style="color: red"><?php echo $this->errors['siteName'] ?? ''; ?></error>
            </div>

            <div class="input-field col s6">
                <input class="<?php (isset($this->errors['rssUrl'])) ? print "invalid" : null ?>" name="rssUrl" id="rssUrl" type="text" class="validate">
                <label for="rssUrl">Rss Url</label>
                <error style="color: red"><?php echo $this->errors['rssUrl'] ?? ''; ?></error>
            </div>

            <input type='hidden' name="action" value='addSite'/>

            <div class="input-field col s12">
                <button class="btn waves-effect waves-light">
                    Submit<i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- TABLE -->
<h3>All current rss flux :</h3>
<table class="z-depth-3 bordered highlight responsive-table">
    <thead>
    <tr>
        <th>SiteName</th>
        <th>RSS</th>
    </tr>
    </thead>

    <tbody>
    <?php
    foreach($this->sites as $site){
        echo"
          <tr href=\"site.com/whatever\">
            <td>".$site->getSiteName()."</td>
            <td><a target=\"_blank\" href=\"".$site->getfluxUrl()."\" > ".$site->getfluxUrl()."</a></td>
            <td><a onclick='handleDeleteClick(".$site->getId().")' class='btn-floating btn-medium waves-effect waves-light red'><i class='material-icons right'>delete</i></a></td>
          </tr>
        ";
    }
    ?>
    </tbody>
</table>