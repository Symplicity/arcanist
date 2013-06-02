<?php

class SympArcanistLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $paths = $this->getPaths();
    $project = $this->getWorkingCopy();
    $config = $project->getProjectConfig();
    if (isset($config['lint.phpcs.standard'])) {
      $php_linter = new ArcanistPhpcsLinter();
    } else {
      $php_linter = new SympXHPASTLinter();
    }
    $linters = array(
      $php_linter
    );
    if (isset($config['lint.jshint.config'])) {
      $js_linter = new ArcanistJSHintLinter();
      $linters[] = $js_linter;
    }

    foreach ($paths as $path) {
      $linter = null;
      if (preg_match('/\.(php|class|inc)$/', $path)) {
        $linter = $php_linter;
      } elseif (isset($js_linter) && preg_match('/\.js$/', $path)) {
        $linter = $js_linter;
      }
      if ($linter) {
        $linter->addPath($path);
      }
    }
    return $linters;
  }

}