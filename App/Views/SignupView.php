<?php include 'App/Views/includes/header.php'; ?>	

<form action = "/signup" method="POST" id="signUp" class="signIn_signUp">
    <table cellpadding="3">
        <tr>
            <td> 
                <h1 class="sign-title"> Sign Up </h1>
            </td>
        </tr>
        <tr>
            <td>
                <div id="error-name" class="error">&nbsp;</div>
                <label for="signup-name">
                <input type="text" id="signup-name" name="name" class = "sign-input" placeholder="Fullname : ...  " required />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <div id="error-pseudo" class="error">&nbsp;</div>
                <label for="signup-pseudo">
                <input type="text" id="signup-pseudo" name="pseuso" class = "sign-input" placeholder="Pseudo : ... " required />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <div id="error-email" class="error">&nbsp;</div>
                <label for="signup-email">
                <input type="email" id="signup-email" name="email" class = "sign-input" placeholder="Email : ... " required />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <div id="error-password" class="error">&nbsp;</div>
                <label for="signup-password">
                <input type="password" id="signup-password" name="password" class = "sign-input" placeholder="Password : ... " required />
                </label>
            </td>
        </tr>
        <tr>
        <tr>
            <td> 
                <div class="notif-pass notif-pass-top">Password must have 8 to 32 characters, </div>
                <div class="notif-pass">at least 1 uppercase letter, 1 number and 1 special character </div>
            </td>
        </tr>
        <tr>
            <td class="last-line"> 
                <input type="submit" id="submit" name="submit-signup" value="Inscription" class = "sign-submit"/>
                <input type="reset" id="reset" name="reset" value="Reset" class = "sign-submit" />
            </td>
        </tr>
        <tr>
            <td>
                <span class="notification"> <?= $data['notification']??''?> </span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="log-message">Returning Customer ? &nbsp;<a href="/signin">Sign in &rarr;</a> </span>
            </td>
        </tr>
    
    </table>
</form>

    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/assets/js/main.js"></script>
</body>
</html>