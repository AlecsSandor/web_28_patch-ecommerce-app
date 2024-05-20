<div id="login_tab" class="tab-content active account-tab">
    <h1 style="font-size: 50px; font-weight: 400;">Login</h1>
    <form id="loginForm" action="http://localhost:8888/backend/api.php" method="POST"
        style="display: flex; flex-direction: column;">
        <input type="hidden" name="action" value="login">

        <label for="email" style="padding-top: 30px;">Email:</label>
        <input type="email" id="email" name="email" required style="height: 60px;">

        <label for="password" style="padding-top: 30px;">Password:</label>
        <input type="password" id="password" name="password" required style="height: 60px;">

        <button type="submit" style="margin-top: 30px;">Login</button>
    </form>
    <div style="border-bottom: 1px solid #e6e6e6; margin-top:40px; margin-bottom:40px;"></div>
</div>

<div id="register_tab" class="tab-content account-tab">
    <h1 style="font-size: 50px; font-weight: 400;">Register</h1>
    <form id="registerForm" method="POST" style="display: flex; flex-direction: column;">
        <input type="hidden" name="action" value="register">

        <label for="email" style="padding-top: 30px;">Email:</label>
        <input type="email" id="email" name="email" required style="height: 60px;">

        <label for="username" style="padding-top: 30px;">Username:</label>
        <input type="usernam" id="username" name="username" required style="height: 60px;">

        <label for="password" style="padding-top: 30px;">Password:</label>
        <input type="password" id="password" name="password" required style="height: 60px;">

        <button type="submit" style="margin-top: 30px;">Register</button>
    </form>
    <div style="border-bottom: 1px solid #e6e6e6; margin-top:40px; margin-bottom:40px;"></div>
</div>
<button onclick="switchTabs()">Switch</button>