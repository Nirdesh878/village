<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/font-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('custom/css/styles.css')); ?>">
    <title>DART</title>
</head>
<body class="body-bg">
<div class="container-fluid">
    <div class="row">
        <div class="cont">
            <div class="demo">
                <div class="login">
                    <div class="login__check"></div>
                    <div class="login__form">

                        <!-- Display success or error messages -->
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(route('otp.generate')); ?>" autocomplete="off">
                        <?php echo csrf_field(); ?>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" style="display: block; font-size:12px" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="login__row">
                            <svg class="login__icon name svg-icon" viewBox="0 0 20 20">
                            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8"></path>
                            </svg>
                            <input class="login__input name <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Email Id" autocomplete="off" name="email" id="email" type="text" value="<?php echo e(old('email')); ?>" required>
                        </div>

                        <div class="login__row">
                            <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
                            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0"></path>
                            </svg>
                            <input class="login__input pass" placeholder="Password" autocomplete="off" name="password" id="password" type="password" required>
                        </div>

                        <button type="submit" class="login__submit">Sign in</button>
                        <p class="login__signup">Don't have an account? &nbsp;<a>Sign up</a></p>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
html, .container-fluid, .row { height:100%; }
html, body { font-size: 65.5%; }
.cont {
    position: relative;
    height: 100%;
    width:100%;
    overflow: auto;
    font-family: "Open Sans", Helvetica, Arial, sans-serif;
}
.demo {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -15rem;
    margin-top: -26.5rem;
    width: 30rem;
    height: 53rem;
    overflow: hidden;
}
.login {
    position: relative;
    height: 100%;
    background: linear-gradient(to bottom, rgba(146, 135, 187, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
    transition: opacity 0.1s, transform 0.3s cubic-bezier(0.17, -0.65, 0.665, 1.25);
    transform: scale(1);
}
.login__check {
    position: absolute;
    top: 16rem;
    left: 13.5rem;
    width: 14rem;
    height: 2.8rem;
    background: #fff;
    transform-origin: 0 100%;
    transform: rotate(-45deg);
}
.login__check:before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 100%;
    width: 2.8rem;
    height: 5.2rem;
    background: #fff;
    box-shadow: inset -0.2rem -2rem 2rem rgb(0 0 0 / 20%);
}
.login__form {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 50%;
    padding: 1.5rem 2.5rem;
    text-align: center;
}
.login__row {
    height: 5rem;
    padding-top: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}
.login__icon {
    margin-bottom: -0.4rem;
    margin-right: 0.5rem;
}
svg {
    overflow: hidden;
    vertical-align: middle;
}
svg {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    overflow: visible;
}
.svg-icon {
    cursor: pointer;
}
.login__input {
    display: inline-block;
    width: 22rem;
    height: 100%;
    padding-left: 1.5rem;
    font-size: 1.5rem;
    background: transparent;
    color: #FDFCFD;
}
input, button {
    outline: none;
    border: none;
}
.svg-icon path {
    stroke: rgba(255, 255, 255, 0.9);
    fill: none;
    stroke-width: 1;
}
.login__icon.name path {
    stroke-dashoffset: 73.50196075439453;
    animation: animatePath 2s 0.5s forwards;
}
.login__submit {
    position: relative;
    width: 100%;
    height: 4rem;
    margin: 5rem 0 2.2rem;
    color: rgba(255, 255, 255, 0.8);
    background: #FF3366;
    font-size: 1.5rem;
    border-radius: 3rem;
    cursor: pointer;
    transition: width 0.3s 0.15s, font-size 0.1s 0.15s;
}
.alert-danger {
    font-size: large;
    margin-top: -71px;
}
</style>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\village\resources\views/auth/login.blade.php ENDPATH**/ ?>