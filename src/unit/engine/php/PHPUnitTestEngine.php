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

    $this->results = array();
    $tests = array();
    foreach ($this->getPaths() as $path) {
      $extension = substr($path, strrpos($path, '.'));
      if (in_array($extension, array('.inc', '.class'))) {
        $test = "./tests/" . str_replace(array('.class', '.inc'), 'Test.php', $path);
        if (file_exists($test)) {
          $tests[$path] = $test;
        } else {
          if (file_exists($test = dirname($test))) {
            $tests[$path] = $test;
          } else {
            $result = new ArcanistUnitTestResult();
            $result->setName($path);
            $result->setResult(ArcanistUnitTestResult::RESULT_FAIL);
            $result->setUserData("         No tests found for $test.");
            $this->results[] = $result;
          }
        }
      }
    }

    foreach ($tests as $test) {
      $this->runningTest = basename($test);
      $this->testStartTime = microtime(true);
      $output = null;
      exec('phpunit ' . $test, $output, $return);
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
  private function recordResult($passed, $output) {
    $result = new ArcanistUnitTestResult();
    if ($passed) {
      $result->setResult(ArcanistUnitTestResult::RESULT_PASS);
      $result->setDuration(microtime(true) - $this->testStartTime);
      $result->setName($this->runningTest);
    } else {
      $result->setResult(ArcanistUnitTestResult::RESULT_FAIL);
      $reason = '';
      foreach ($output as $line) {
        if (trim($line) && !preg_match('#^(PHPUnit|Time|There was|FAILURES|Tests:|[F\.]+$)#', $line)) {
          $matches = array();
          if (preg_match('/\d+\) (.+::.+)/', $line, $matches)) {
            $result->setName($matches[1]);
          } elseif (preg_match('#/.+.php:(\d+)#', $line, $matches)) {
            $reason .= " (line {$matches[1]})";
          } elseif (!$reason) {
            $reason .= $line;
          }
        }
      }
      $result->setUserData("         $reason");
    }
    $this->results[] = $result;
  }

}
