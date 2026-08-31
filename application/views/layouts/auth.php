<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Login to CRM PT. Indoneptune Net Mfg</title>
    <link href="<?= base_url(); ?>assets/favicon.ico" rel="icon">
    <!-- CSS files -->
    <link href="<?= base_url().'assets/src' ?>/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="<?= base_url().'assets/src' ?>/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="<?= base_url().'assets/src' ?>/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="<?= base_url().'assets/src' ?>/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="<?= base_url().'assets/src' ?>/css/demo.min.css?1692870487" rel="stylesheet"/>

    <link href="<?= base_url().'assets/css' ?>/own-style.css?1692870487" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    <noscript>
        <style type="text/css">
            .page {
            display: none;
            }
        </style>
        <div class="noscriptmsg">
            You don't have javascript enabled. Good luck with that.
        </div>
    </noscript>
  </head>
  <body  class=" d-flex flex-column">
    <script src="<?= base_url().'assets/src' ?>/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center" style="background-image: url(<?= base_url() ?>/assets/img/assets/backgrifn.jpg)">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
        </div>
        <div class="card card-md">
          <div class="card-body">
            <?= $this->session->flashdata('message'); ?>
            <h2 class="h2 text-center mb-4">Login CRM</h2>
            <form action="<?= base_url().'auth/auth' ?>" method="post" autocomplete="off" novalidate>
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="email" class="form-control" placeholder="User Name" name="username" autocomplete="off">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                </label>
                <div class="input-group input-group-flat">
                  <input type="password" class="form-control"  placeholder="Your password" name="password" autocomplete="off">
                  <span class="input-group-text">
                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                    </a>
                  </span>
                </div>
              </div>
              <div class="mb-2">
                <label class="form-label">
                    <label class="form-check">
                        <input type="checkbox" class="form-check-input" name="ingatsaya"/>
                        <span class="form-check-label text-muted">Ingat Saya</span>
                    </label>
                    <!-- <span class="form-label-description">
                        <a href="./">Lupa Password</a>
                    </span> -->
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
        </div>
        <div class="text-center text-secondary mt-3">
          Belum punya Akun? <a href="./" tabindex="-1">Sign up</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url().'assets/src' ?>/js/tabler.min.js?1692870487" defer></script>
    <script src="<?= base_url().'assets/src' ?>/js/demo.min.js?1692870487" defer></script>
  </body>
</html>