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
      $test = "./tests/" . str_replace('.class', 'Test.php', $path);
      if (file_exists($test)) {
        $tests[$path] = $test;
        echo $path . " $test\n";
      }
      //$full_path = Filesystem::resolvePath($path);
    }

    if (!$tests) {
      throw new ArcanistNoEffectException("No tests to run.");
    }

    $results = array();
    foreach ($tests as $test) {
      $result = $runner->doRun($test);
    }
    if ($results) {
      $results = call_user_func_array('array_merge', $results);
    }

    return $results;
  }

}
