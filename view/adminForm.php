<nav>
    <div class="nav-wrapper teal lighten-2">
        <a class="brand-logo">Admin Connection :</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li>
                <form id="backToNews" method="POST" action="index.php">
                    <input type='hidden' name="action" value=''/>
                    <a href="#" onclick="document.getElementById('backToNews').submit()"><i class="small material-icons right">info_outline</i>Go back to News</a>
                </form>
            </li>
        </ul>
    </div>
</nav>

<form class="col s12" method="POST" action='index.php' id='adminConnectForm'>
    <div class="input-field col s12">
        <label for = "userName"> Username: </label>
        <input name='userName' type="text" id="userName"/>
        <error style="color: red"><?php echo $this->errors['userName'] ?? ''; ?></error>
    </div>

    <div class="input-field col s12">
        <label for = "password"> Password: </label>
        <input name='password' type="password" id="password"/>
        <error style="color: red"><?php echo $this->errors['password'] ?? ''; ?></error>
    </div>

    <input type='hidden' name="action" value='connectAsAdmin'/>

    <div class="input-field col s12">
        <button class="btn waves-effect waves-light">
            Submit<i class="material-icons right">send</i>
        </button>
    </div>
</form>
