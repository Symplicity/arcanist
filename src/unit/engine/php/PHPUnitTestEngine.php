<?php

/*
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Very basic unit test engine which runs phpunit tests.
 *
 * @group unitrun
 */
class PHPUnitTestEngine extends ArcanistBaseUnitTestEngine {

  public function run() {

    $tests = array();
    foreach ($this->getPaths() as $path) {
      $test = "./tests/" . str_replace(array('.class', '.inc'), 'Test.php', $path);
      if (file_exists($test)) {
        $tests[$path] = $test;
      }
    }

    if (!$tests) {
      throw new ArcanistNoEffectException("No tests to run.");
    }

    $this->results = array();
    foreach ($tests as $test) {
      $this->testStartTime = microtime(true);
      exec('/Users/svemir/www/backup/PHPUnit/phpunit.php ' . $test, $output, $return);
      $this->recordResult($return === 0, $output);
    }

    return $this->results;
  }

  /**
   * Mark the currently-running test as a failure or success.
   *
   * @param boolean  Did it pass?
   * @param array  PHPUnit output.
   * @return void
   */
  final private function recordResult($passed, $output) {
    $result = new ArcanistUnitTestResult();
    $result->setName($this->runningTest);
    $result->setResult($passed ? ArcanistUnitTestResult::RESULT_PASS : ArcanistUnitTestResult::RESULT_FAIL);
    $result->setDuration(microtime(true) - $this->testStartTime);
    $reason = '';
    foreach ($output as $line) {
      if (trim($line) && !preg_match('#^(PHPUnit|Time|There was|FAILURES|Tests:)#', $line)) {
        $reason .= $line . "\n";
      }
    }
    $result->setUserData($reason);
    $this->results[] = $result;
  }

}
