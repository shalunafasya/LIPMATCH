<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">

<style>
  * {
    box-sizing: border-box;
  }
  body, html {
    height: 100%;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
    background-color: #FBD8DC !important;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  body, html {
  background: #FBD8DC !important;
}

.container, .wrapper, main {
  background: transparent !important;
}

  .login-box {
    display: flex;
    max-width: 800px;
    width: 90%;
    background: white;
    border-radius: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    overflow: hidden;
  }
  .login-image {
    flex: 1;
    background: #fafafa;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .login-image img {
    width: 100%;
    max-width: 400px;
    object-fit: cover;
  }
  .login-form {
    flex: 1;
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  .login-form h2 {
    margin-bottom: 30px;
    color: #333;
    font-weight: 600;
    font-size: 2rem;
    letter-spacing: 1.2px;
    text-align: center;
    text-transform: uppercase;
  }
  .form-group {
    margin-bottom: 22px;
  }
  .form-control {
    width: 100%;
    padding: 14px 18px;
    border: 1.5px solid #ccc;
    border-radius: 40px;
    font-size: 16px;
    transition: border-color 0.3s ease;
  }
  .form-control:focus {
    border-color: #EA84B4;
    outline: none;
    background: #fafafa;
  }
  .btn-login {
    width: 100%;
    padding: 14px 0;
    background-color: #EA84B4;
    border: none;
    border-radius: 40px;
    color: white;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }
  .btn-login:hover {
    background-color:hsl(332, 65.20%, 65.10%);
  }
  @media(max-width: 700px) {
    .login-box {
      flex-direction: column;
      border-radius: 20px;
    }
    .login-image img {
      max-width: 100%;
      height: auto;
    }
    .login-form {
      padding: 30px 20px;
    }
  }
</style>

<div class="login-box">
  <div class="login-image">
    <img src="/assets/image/logo.jpg" alt="Logo Lipmatch" />
  </div>
  <div class="login-form">
    <h2>LOGIN ADMIN</h2>
    <form method="POST" action="<?=site_url('login/proses')?>" class="user">
      <div class="form-group">
                                            <input name="username" type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Username..." required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Password">
                                        </div>
                                        <button name="login" class="btn btn-primary btn-user btn-block"> 
                                            Masuk
                                        </button>
                                    </form>
  </div>
</div>
