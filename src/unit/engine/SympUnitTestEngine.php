<?php

/**
 * Very basic unit test engine which runs tests using a script from
 * configuration and expects an XUnit compatible result.
 *
 * @group unit
 */
class SympUnitTestEngine extends ArcanistUnitTestEngine {
    public function run() {
        return $this->runSpecificTests();
    }

    private function runSpecificTests() {
        $results = array();
        $tests = array();
        $non_specific = false;
        foreach ($this->getPaths() as $path) {
            $extension = substr($path, strrpos($path, '.'));
            if ($extension === '.php') {
                if (preg_match('#src/#', $path)) {
                    $test = str_replace(array('src/', '.php'), array('tests/spec/', 'Spec.php'), $path);
                    if (file_exists($test)) {
                        $tests[] = $test;
                    } elseif (!preg_match('#tools/|Formdef/|Listdef/#', $path) && file_exists($path)) {
                        $result = new ArcanistUnitTestResult();
                        $result->setName("Missing $test");
                        $result->setResult(ArcanistUnitTestResult::RESULT_FAIL);
                        $result->setUserData("         No tests found for $path");
                        $results[] = $result;
                    }
                } elseif (preg_match('#Spec.php$#', $path)) {
                    $tests[] = $path;
                }
            } elseif ($extension === '.js') {
                $non_specific = true;
            }
        }

        $path = $this->getConfiguredTestResultPath();
        foreach (glob($path . "/*-results.xml") as $filename) {
            // Remove existing files so we cannot report old results
            $this->unlink($filename);
        }

        foreach ($tests as $key => $test) {
            exec("/www/composer/bin/phpspec --no-interaction run -fjunit $test > $path/spec$key-results.xml");
        }

        if ($non_specific) {
            $this->runTests();
        }
        $results = array_merge($results, $this->parseTestResults($path));

        return $results;
    }

    private function runTests() {
        $root = $this->getWorkingCopy()->getProjectRoot();
        $script = $this->getConfiguredScript();
        $path = $this->getConfiguredTestResultPath();

        $future = new ExecFuture('%C %s', $script, $path);
        $future->setCWD($root);
        try {
            $future->resolvex();
        } catch(CommandException $exc) {
            if ($exc->getError() != 0) {
                throw $exc;
            }
        }
    }

    public function parseTestResults($path) {
        $results = array();

        foreach (glob($path."/*-results.xml") as $filename) {
            $parser = new ArcanistXUnitTestResultParser();
            $result = Filesystem::readFile($filename);
            $result = str_replace("spec\\Symplicity\\Voice\\", '', $result);
            $results[] = $parser->parseTestResults($result);
        }

        return array_mergev($results);
    }

    private function unlink($filepath) {
        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    /**
     * Load, validate, and return the "script" configuration.
     *
     * @return string The shell command fragment to use to run the unit tests.
     *
     * @task config
     */
     private function getConfiguredScript() {
        $key = 'unit.sympunit.script';
        $config = $this->getConfigurationManager()
         ->getConfigFromAnySource($key);

        if (!$config) {
            throw new ArcanistUsageException(
            "SympUnitTestEngine: ".
            "You must configure '{$key}' to point to a script to execute.");
        }

        return $config;
    }

    private function getConfiguredTestResultPath() {
        $key = 'unit.sympunit.result_path';
        $config = $this->getConfigurationManager()
         ->getConfigFromAnySource($key);

        if (!$config) {
            throw new ArcanistUsageException(
            "SympUnitTestEngine: ".
            "You must configure '{$key}' to point to a path.");
        }

        return $config;
    }
}
