<?php

class SympArcanistLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $linters = array();
    $paths = $this->getPaths();
    $project = $this->getWorkingCopy();
    $config = $project->getProjectConfig();
    if (isset($config['lint.phpcs.standard'])) {
      $xhpast_linter = new ArcanistPhpcsLinter();
	} else {
      $xhpast_linter = new SympXHPASTLinter();
	}
    $linters[] = $xhpast_linter;
    foreach ($paths as $path) {
      if (preg_match('/\.(php|class|inc)$/', $path)) {
        $data = $this->loadData($path);
        if ($data) {
          $xhpast_linter->addPath($path);
          $xhpast_linter->addData($path, $data);
        }
      }
    }
    return $linters;
  }

}