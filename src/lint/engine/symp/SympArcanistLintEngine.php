<?php

class SympArcanistLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $paths = $this->getPaths();
    $project = $this->getWorkingCopy();
    if ($project->getProjectConfig('lint.phpcs.standard')) {
      $php_linter = new ArcanistPhpcsLinter();
    } else {
      $php_linter = new SympXHPASTLinter();
    }
    $linters = array(
      $php_linter
    );
    if ($project->getProjectConfig('lint.jshint.config')) {
      $js_linter = new ArcanistJSHintLinter();
      $linters[] = $js_linter;
    }
    if (file_exists('.csslintrc')) {
      $css_linter = new ArcanistCSSLintLinter();
      $linters[] = $css_linter;
    }
    $json_linter = new ArcanistJSONLintLinter();
    $linters[] = $json_linter;

    foreach ($paths as $path) {
      $linter = null;
      if (preg_match('/\.(php|class|inc)$/', $path)) {
        $linter = $php_linter;
      } elseif (isset($css_linter) && preg_match('/\.css$/', $path)) {
        $linter = $css_linter;
      } elseif (isset($js_linter) && preg_match('/\.js$/', $path)) {
        $linter = $js_linter;
      } elseif (isset($json_linter) && preg_match('/\.json$/', $path)) {
        $linter = $json_linter;
      }
      if ($linter) {
        $linter->addPath($path);
      }
    }
    return $linters;
  }

}