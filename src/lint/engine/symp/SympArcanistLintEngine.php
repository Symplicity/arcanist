<?php

class SympArcanistLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $linters = array();

    $paths = $this->getPaths();
    foreach ($paths as $key => $path) {
      if (!$this->pathExists($path)) {
        unset($paths[$key]);
      }
    }

    $xhpast_linter = new SympXHPASTLinter();
    $linters[] = $xhpast_linter;
    foreach ($paths as $path) {
      if (preg_match('/\.php$/', $path)) {
        $xhpast_linter->addPath($path);
        $xhpast_linter->addData($path, $this->loadData($path));
      }
    }
    return $linters;
  }

}
