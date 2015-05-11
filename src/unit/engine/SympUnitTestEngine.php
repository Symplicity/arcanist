<?php

/**
 * Very basic unit test engine which runs tests using a script from
 * configuration and expects an XUnit compatible result.
 *
 * @group unit
 */
class SympUnitTestEngine extends ArcanistUnitTestEngine {
    public function run() {
        $results = array_merge(
            $this->runSpecificTests(),
            $this->runTests()
        );
        return $results;
    }

    private function runSpecificTests() {
        $results = array();
        $tests = array();
        foreach ($this->getPaths() as $path) {
            $extension = substr($path, strrpos($path, '.'));
            if ($extension === '.php' && preg_match('#src/#', $path)) {
                $test = str_replace(array('src/', '.php'), array('test/spec/', 'Spec.php'), $path);
                if (file_exists($test)) {
                    $tests[] = $test;
                } elseif (!preg_match('#tools/|Formdef/#', $path) && file_exists($path)) {
                    $result = new ArcanistUnitTestResult();
                    $result->setName("Missing $test");
                    $result->setResult(ArcanistUnitTestResult::RESULT_FAIL);
                    $result->setUserData("         No tests found for $path");
                    $results[] = $result;
                }
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

        return $this->parseTestResults($path);
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
