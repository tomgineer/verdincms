<?= $this->extend('layout_app') ?>
<?= $this->section('main') ?>

<section class="mt-4 mt-sm-1">

    <div class="container container--lg">

        <?php if ( empty($error) ):?>

            <div class="login mb-5">
                <img class="login__image" src="<?=path_gfx().'monsters/monster_keys.svg?v=3'?>" alt="Login Image" loading="lazy">
                <div class="login__main">
                    <h1>Welcome back!</h1>
                    <p><span class="login__raised">Please log in to continue accessing your account.</span><br>New here? Click Sign Up to create your account and get started in seconds.</p>

                    <form action="<?=site_url('users/login')?>" method="post">
                        <?= csrf_field() ?>

                        <div class="fieldset mb-05">
                            <label class="fieldset__label">Email</label>
                            <input class="fieldset__control" type="email" name="email" placeholder="Email" minlength="8" required>
                        </div>

                        <div class="fieldset mb-15">
                            <label class="fieldset__label">Password</label>
                            <input class="fieldset__control" type="password" name="password" placeholder="Password" minlength="3" required>
                        </div>

                        <div class="login__buttonset">
                            <a class="login__button disabled" href="<?=site_url('register')?>">Sign Up</a>
                            <button class="login__button">Log in</button>
                        </div>

                    </form>

                </div>
            </div>

        <?php else:?>

            <div class="login mb-5">
                <img class="login__image" src="<?=path_gfx().'monsters/monster_shocked.svg?v=3'?>" alt="Login Failure">
                <div class="login__main">
                    <h2>Well, That Didn't Work...</h2>
                    <p>If at first you don’t succeed, try yelling at your screen. That usually helps.</p>

                </div>
            </div>

        <?php endif;?>

    </div>

</section>

<?= $this->endSection() ?>