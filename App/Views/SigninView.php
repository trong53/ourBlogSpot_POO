<?php include 'App/Views/includes/header.php'; ?>	

<form action = "/signin" method="POST" id="signIn" class="signIn_signUp">
    <table cellpadding="12">
        <tr>
            <td> 
                <h1 class="sign-title"> Sign In </h1>
            </td>
        </tr>
        <tr>
            <td> 
                <label for="email">
                <input type="email" id="email" name="email" class = "sign-input" placeholder="Email : ... " required />
                </label>
            </td>
        </tr>
        <tr>
            <td> 
                <label for="password">
                <input type="password" id="password" name="password" class = "sign-input" placeholder="Password : ... " required />
                </label>
            </td>
        </tr>
        <tr>
        <tr>
            <td class="last-line"> 
                <input type="submit" id="submit" name="submit-signin" value="Log in" class = "sign-submit"/>
            </td>
        </tr>
        <tr>
            <td>
                <span class="notification"> <?= $data['notification']??''?> </span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="log-message">New Customer ? &nbsp;<a href="/signup">Sign up &rarr;</a> </span>
            </td>
        </tr>
    
    </table>
</form>

<div class="<?= $data['warning']??'warning-hidden'?>">
    <div class="warning-close">&times;</div>
    <div class="warning-message">
        Your account has been blocked. 
        <br> If any question, you can contact the administrator
    </div> 
</div>

    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/assets/js/main.js"></script>
</body>
</html>

