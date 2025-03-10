<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <title>Document</title>
</head>
<style>
	.dead{
		opacity : 0.5;
		cursor: no-drop !important;
	}
</style>
<body class="bg-dark">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
			
                <!-- <form action="<?= base_url('do-register') ?>" method="post" class="bg-white p-5 rounded-3"> 
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" value="<?= old('name') ?>">
						<?php if(session()->getFlashdata('errors')['name'] ?? false) : ?>
							<span class="text-danger"><?= session()->getFlashdata('errors')['name'] ?></span>
						<?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= old('email') ?>">
						<?php if(session()->getFlashdata('errors')['email'] ?? false) : ?>
							<span class="text-danger"><?= session()->getFlashdata('errors')['email'] ?></span>
						<?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" >
						<?php if(session()->getFlashdata('errors')['password'] ?? false) : ?>
							<span class="text-danger"><?= session()->getFlashdata('errors')['password'] ?></span>
						<?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form> -->


                <!-- <form action="<?= base_url('do-register') ?>" method="post" class="bg-white p-5 rounded-3"> 
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" value="<?= old('name') ?>">
						<small class="text-danger">
							<?= session('errors.name') ?>
						</small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= old('email') ?>">
						<small class="text-danger">
							<?= session('errors.email') ?>
						</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
						<small class="text-danger">
							<?= session('errors.password') ?>
						</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form> -->

                <form id="formAjax" class="bg-white p-5 rounded-3"> 
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" >
						<span class="text-danger" id="nameError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" >
						<span class="text-danger" id="emailError"></span>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
						<span class="text-danger" id="passwordError"></span>
                    </div>
                    <button id="formSubmit" type="submit" class="btn btn-primary">Submit</button>
                </form>
				
				<script>
					$(document).ready(function(){
						const notyf = new Notyf({
						  duration: 1000,
						  position: {
							x: 'right',
							y: 'top',
						  },
						});
						
						$("#formAjax").on('submit', function(e){
							e.preventDefault();
							// notyf.success('submit');
							
							$("#nameError, #emailError, #passwordError").text('');
							
							$("#formSubmit").html('processing...').addClass('dead disabled');
							$.ajax({
								url : "<?= base_url('do-register') ?>",
								type : "post",
								data : $(this).serialize(),
								dataType : "json",
								
								success : function(response){
									
									$("#formSubmit").html('Submit').removeClass('dead disabled');
									
									if(response.success){
										notyf.success('Register succesfull!');
										$("#formAjax")[0].reset();
									}else{
										if(response.errors.name){
											$("#nameError").text(response.errors.name);
										}
										if(response.errors.email){
											$("#emailError").text(response.errors.email);
										}
										if(response.errors.password){
											$("#passwordError").text(response.errors.password);
										}
									}
									
								},
								
								error : function(xhr, status, error){
									notyf.error('Server down');
								}
								
							});
							
						});
					});
				</script>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>