<?= $this->extend('frontend/layouts/default') ?>
<?= $this->section('main') ?>

<section class="pt-8 sm:pt-16 custom-bg-1 min-h-[800px]">
    <div class="mx-auto w-full max-w-3xl px-4">

        <?php if (empty($error)): ?>

            <div class="card bg-base-200 shadow-sm">
                <div class="card-body gap-4 sm:gap-6">
                    <div>
                        <h1 class="card-title text-2xl sm:text-3xl">Welcome back!</h1>
                        <p class="text-base-content/80">
                            <span class="font-medium text-base-content">Please log in to continue accessing your account.</span><br>
                            New here? Click <span class="font-medium">Sign Up</span> to create your account and get started in seconds.
                        </p>
                    </div>

                    <form action="<?= site_url('users/login') ?>" method="post" class="grid gap-4 sm:gap-5">
                        <?= csrf_field() ?>

                        <div class="form-control">
                            <label class="label" for="email">
                                <span class="label-text">Email</span>
                            </label>
                            <input
                                id="email"
                                class="input input-bordered w-full"
                                type="email"
                                name="email"
                                placeholder="you@example.com"
                                minlength="8"
                                required
                                autocomplete="username"
                            />
                        </div>

                        <div class="form-control">
                            <label class="label" for="password">
                                <span class="label-text">Password</span>
                            </label>
                            <input
                                id="password"
                                class="input input-bordered w-full"
                                type="password"
                                name="password"
                                placeholder="••••••••"
                                minlength="3"
                                required
                                autocomplete="current-password"
                            />
                        </div>

                        <div class="mt-2 flex flex-col-reverse gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <a class="btn btn-ghost sm:btn-outline pointer-events-none opacity-50" href="#">Sign Up</a>
                            <button class="btn btn-primary" type="submit">Log in</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <div class="card bg-base-200 shadow-sm">
                <div class="card-body items-center text-center gap-4 sm:gap-6">
                    <div>
                        <h2 class="card-title text-xl sm:text-2xl">Well, That Didn't Work...</h2>
                        <p class="text-base-content/80">
                            If at first you don’t succeed, try yelling at your screen. That usually helps.
                        </p>
                    </div>
                    <div class="w-full sm:w-auto">
                        <a class="btn btn-primary" href="<?= site_url('login') ?>">Try Again</a>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</section>

<?= $this->endSection() ?>
