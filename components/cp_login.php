<section class="sec-filmes pb-5" id="lista-filmes">
    <div class= "container px-lg-5 pt-3">

<?php include_once "components/cp_intro_login.php" ?>

<div class="row">
<h1>Aqui podes inserir os teus dados!</h1>

<form class="col-6" action="./scripts/sc_login.php" method="post" class="was-validated">
 <div class="mb-3 mt-3">
 <label for="uname" class="form-label">Login:</label>
 <input type="text" class="form-control" id="login" 
placeholder="Enter login" name="login" required>
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <div class="mb-3">
 <label for="pwd" class="form-label">Password:</label>
 <input type="password" class="form-control" id="password" 
placeholder="Enter password" name="password" required>
 <div class="valid-feedback">Valid.</div>
 <div class="invalid-feedback">Please fill out this field.</div>
 </div>
 <button type="submit" class="btn btn-primary">Confirmar</button>
</form>
</div>
</div>
</section>
