<!DOCTYPE html >
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body class="bg-dark">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
			
                <form action="<?= base_url('do-login') ?>" method="post" class="bg-white p-5 rounded-3" > 
				
				<small class="text-center" style="color: green;">
					<?= session('success') ?>
				</small>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input  type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= service('request')->getCookie('remember_email'); ?>">
						
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" value="<?= service('request')->getCookie('remember_password'); ?>">
						
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe"
                            <?= service('request')->getCookie('remember_email') ? 'checked' : '' ?>
                        >
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>