<?php defined( '_JEXEC' ) or die;
include_once JPATH_THEMES.'/'.$this->template.'/logic.php';
?>

<!doctype html>
<html lang="<?php echo $this->language; ?>">

  <head>
      <jdoc:include type="head" />
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-141581902-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-141581902-1');
        gtag('config', 'AW-1061303413');
      </script>
      <?php if ($this->countModules('google-script')) : ?>
        <jdoc:include type="modules" name="google-script" />
      <?php endif; ?>
  </head>

  <body class="<?php echo $active->alias . ' ' . $pageclass; ?>">

    <header class="header">
      <div class="container mt-3 px-0">
          <div class="d-flex justify-content-center justify-content-lg-between">
            <a class="navbar-brand d-inline-flex flex-wrap align-items-baseline" href="/">
              <img class="logo" src="<?php echo $tpath; ?>/images/cimes-logo.svg" alt="Cimes logo" />
            </a>
            <div class="header-top d-none d-lg-block">
              <div class="d-flex justify-content-end">
                  <jdoc:include type="modules" name="header-top" />
              </div>
            </div>
        </div>

        <p class="slogan mb-0 d-none d-lg-block"><jdoc:include type="modules" name="slogan" /></p>
      </div>

      <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <p class="slogan mb-0 d-none d-md-block d-lg-none text-center" style="flex: 1 0 auto;"><jdoc:include type="modules" name="slogan" /></p>

        <div id="navbarDefault" class="collapse navbar-collapse">
          <div class="container d-flex">
            <jdoc:include type="modules" name="navbar" />
            <div class="d-flex d-lg-none">
              <jdoc:include type="modules" name="header-top" />
            </div>
          </div>
        </div>
      </nav>
    </header>

    <main class="main">
      <jdoc:include type="message" />
      <jdoc:include type="component" />
      <?php if ($this->countModules('component-below')) : ?>
        <div class="container">
          <hr />
          <jdoc:include type="modules" name="component-below" style="html5" />
        </div>
      <?php endif; ?>
    </main>

    <footer class="footer">
      <div class="footer-main">
        <div class="container">
          <?php if ($this->countModules('footer-above')) : ?>
            <jdoc:include type="modules" name="footer-above" />
          <?php endif; ?>

          <div class="row">
            <div class="col-12 d-flex">
              <jdoc:include type="modules" name="footer" />
            </div>
          </div>
        </div>
      </div>
      <div class="footer-below">
        <div class="container">
          <jdoc:include type="modules" name="footer-below" />
        </div>
      </div>
    </footer>

    <jdoc:include type="modules" name="debug" />
  </body>

</html>
