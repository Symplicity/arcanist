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
 * Uses XHPAST to apply lint rules to PHP or PHP+XHP.
 *
 * @group linter
 */
class SympXHPASTLinter extends ArcanistLinter {

  private $trees = array();

  const LINT_PHP_SYNTAX_ERROR         = 1;
  const LINT_UNABLE_TO_PARSE          = 2;
  const LINT_EXTRACT_USE              = 3;
  const LINT_TAUTOLOGICAL_EXPRESSION  = 4;
  const LINT_PLUS_OPERATOR_ON_STRINGS = 5;
  const LINT_STATIC_THIS              = 6;
  const LINT_DUPLICATE_KEYS_IN_ARRAY  = 7;
  const LINT_REUSED_ITERATORS         = 8;
  const LINT_IMPLICIT_CONSTRUCTOR     = 9;
  const LINT_DYNAMIC_DEFINE           = 10;
  const LINT_PREG_QUOTE_MISUSE        = 11;
  const LINT_EXIT_EXPRESSION          = 12;
  const LINT_NAMING_CONVENTIONS       = 13;
  const LINT_FORMATTING_CONVENTIONS   = 14;
  const LINT_TODO_COMMENT             = 15;

  public function getLintNameMap() {
    return array(
      self::LINT_PHP_SYNTAX_ERROR         => 'PHP Syntax Error!',
      self::LINT_DYNAMIC_DEFINE           => 'Dynamic define()',
      self::LINT_PREG_QUOTE_MISUSE        => 'Misuse of preg_quote()',
      self::LINT_EXIT_EXPRESSION          => 'Exit Used as Expression',
      self::LINT_TAUTOLOGICAL_EXPRESSION  => 'Tautological Expression',
      self::LINT_PLUS_OPERATOR_ON_STRINGS => 'Not String Concatenation',
      self::LINT_DUPLICATE_KEYS_IN_ARRAY  => 'Duplicate Keys in Array',
      self::LINT_REUSED_ITERATORS         => 'Reuse of Iterator Variable',
      self::LINT_TODO_COMMENT => 'TODO Comment',
      self::LINT_UNABLE_TO_PARSE => 'Unable to Parse',
      self::LINT_STATIC_THIS => 'Use of $this in Static Context',
      self::LINT_FORMATTING_CONVENTIONS => 'Formatting Conventions',
      self::LINT_NAMING_CONVENTIONS => 'Naming Conventions',
      self::LINT_IMPLICIT_CONSTRUCTOR => 'Implicit Constructor',
      self::LINT_EXTRACT_USE => 'Use of extract()',
    );
  }

  public function getLinterName() {
    return 'SO';
  }

  public function getLintSeverityMap() {
    return array(
      self::LINT_TODO_COMMENT
        => ArcanistLintSeverity::SEVERITY_ADVICE,
      self::LINT_UNABLE_TO_PARSE
        => ArcanistLintSeverity::SEVERITY_WARNING,
      self::LINT_STATIC_THIS
        => ArcanistLintSeverity::SEVERITY_WARNING,
      self::LINT_FORMATTING_CONVENTIONS
        => ArcanistLintSeverity::SEVERITY_WARNING,
      self::LINT_NAMING_CONVENTIONS
        => ArcanistLintSeverity::SEVERITY_WARNING,
      self::LINT_IMPLICIT_CONSTRUCTOR
        => ArcanistLintSeverity::SEVERITY_WARNING,
      self::LINT_EXTRACT_USE
        => ArcanistLintSeverity::SEVERITY_WARNING,
    );
  }

  public function willLintPaths(array $paths) {
    $futures = array();
    foreach ($paths as $path) {
      $futures[$path] = xhpast_get_parser_future($this->getData($path));
    }
    foreach ($futures as $path => $future) {
      $this->willLintPath($path);
      try {
        $this->trees[$path] = XHPASTTree::newFromDataAndResolvedExecFuture(
          $this->getData($path),
          $future->resolve());
      } catch (XHPASTSyntaxErrorException $ex) {
        $this->raiseLintAtLine(
          $ex->getErrorLine(),
          1,
          self::LINT_PHP_SYNTAX_ERROR,
          'This file contains a syntax error: '.$ex->getMessage());
        $this->stopAllLinters();
        return;
      } catch (Exception $ex) {
        $this->raiseLintAtPath(
          self::LINT_UNABLE_TO_PARSE,
          'XHPAST could not parse this file, probably because the AST is too '.
          'deep. Some lint issues may not have been detected. You may safely '.
          'ignore this warning.');
        return;
      }
    }
  }

  public function getXHPASTTreeForPath($path) {
    return idx($this->trees, $path);
  }

  public function lintPath($path) {
    if (empty($this->trees[$path])) {
      return;
    }

    $root = $this->trees[$path]->getRootNode();

    $this->lintUseOfThisInStaticMethods($root);
    $this->lintDynamicDefines($root);
    //$this->lintSurpriseConstructors($root);
    //$this->lintTODOComments($root);
    //$this->lintExitExpressions($root);
    $this->lintSpaceAroundBinaryOperators($root);
    $this->lintSpaceAfterControlStatementKeywords($root);
    $this->lintParenthesesShouldHugExpressions($root);
    $this->lintNamingConventions($root);
    $this->lintPregQuote($root);
    $this->lintArrayIndexWhitespace($root);
    $this->lintTautologicalExpressions($root);
    //$this->lintPlusOperatorOnStrings($root);
    $this->lintDuplicateKeysInArray($root);
    //$this->lintReusedIterators($root);
    $this->lintBraceFormatting($root);
    $this->lintSpaceIndent($root);
  }

  private function lintBraceFormatting($root) {

    foreach ($root->selectDescendantsOfType('n_STATEMENT_LIST') as $list) {
      $tokens = $list->getTokens();
      if (!$tokens || head($tokens)->getValue() != '{') {
        continue;
      }
      list($before, $after) = $list->getSurroundingNonsemanticTokens();
      if (count($before) == 1) {
        $before = reset($before);
        if ($before->getValue() != ' ') {
          $this->raiseLintAtToken(
            $before,
            self::LINT_FORMATTING_CONVENTIONS,
            'Put opening braces on the same line as control statements and '.
            'declarations, with a single space before them.',
            ' ');
        }
      }
    }

  }

  private function lintTautologicalExpressions($root) {
    $expressions = $root->selectDescendantsOfType('n_BINARY_EXPRESSION');

    static $operators = array(
      '-'   => true,
      '/'   => true,
      '-='  => true,
      '/='  => true,
      '<='  => true,
      '<'   => true,
      '=='  => true,
      '===' => true,
      '!='  => true,
      '!==' => true,
      '>='  => true,
      '>'   => true,
    );

    static $logical = array(
      '||'  => true,
      '&&'  => true,
    );

    foreach ($expressions as $expr) {
      $operator = $expr->getChildByIndex(1)->getConcreteString();
      if (!empty($operators[$operator])) {
        $left = $expr->getChildByIndex(0)->getSemanticString();
        $right = $expr->getChildByIndex(2)->getSemanticString();

        if ($left == $right) {
          $this->raiseLintAtNode(
            $expr,
            self::LINT_TAUTOLOGICAL_EXPRESSION,
            'Both sides of this expression are identical, so it always '.
            'evaluates to a constant.');
        }
      }

      if (!empty($logical[$operator])) {
        $left = $expr->getChildByIndex(0)->getSemanticString();
        $right = $expr->getChildByIndex(2)->getSemanticString();

        // NOTE: These will be null to indicate "could not evaluate".
        $left = $this->evaluateStaticBoolean($left);
        $right = $this->evaluateStaticBoolean($right);

        if (($operator == '||' && ($left === true || $right === true)) ||
            ($operator == '&&' && ($left === false || $right === false))) {
          $this->raiseLintAtNode(
            $expr,
            self::LINT_TAUTOLOGICAL_EXPRESSION,
            'The logical value of this expression is static. Did you forget '.
            'to remove some debugging code?');
        }
      }
    }
  }


  /**
   * Statically evaluate a boolean value from an XHP tree.
   *
   * TODO: Improve this and move it to XHPAST proper?
   *
   * @param  string The "semantic string" of a single value.
   * @return mixed  ##true## or ##false## if the value could be evaluated
   *                statically; ##null## if static evaluation was not possible.
   */
  private function evaluateStaticBoolean($string) {
    switch (strtolower($string)) {
      case '0':
      case 'null':
      case 'false':
        return false;
      case '1':
      case 'true':
        return true;
    }
    return null;
  }

  /**
   * Find cases where loops get nested inside each other but use the same
   * iterator variable. For example:
   *
   *  COUNTEREXAMPLE
   *  foreach ($list as $thing) {
   *    foreach ($stuff as $thing) { // <-- Raises an error for reuse of $thing
   *      // ...
   *    }
   *  }
   *
   */
  private function lintReusedIterators($root) {
    $used_vars = array();

    $for_loops = $root->selectDescendantsOfType('n_FOR');
    foreach ($for_loops as $for_loop) {
      $var_map = array();

      // Find all the variables that are assigned to in the for() expression.
      $for_expr = $for_loop->getChildOfType(0, 'n_FOR_EXPRESSION');
      $bin_exprs = $for_expr->selectDescendantsOfType('n_BINARY_EXPRESSION');
      foreach ($bin_exprs as $bin_expr) {
        if ($bin_expr->getChildByIndex(1)->getConcreteString() == '=') {
          $var_map[$bin_expr->getChildByIndex(0)->getConcreteString()] = true;
        }
      }

      $used_vars[$for_loop->getID()] = $var_map;
    }

    $foreach_loops = $root->selectDescendantsOfType('n_FOREACH');
    foreach ($foreach_loops as $foreach_loop) {
      $var_map = array();

      $foreach_expr = $foreach_loop->getChildOftype(0, 'n_FOREACH_EXPRESSION');

      // We might use one or two vars, i.e. "foreach ($x as $y => $z)" or
      // "foreach ($x as $y)".
      $possible_used_vars = array(
        $foreach_expr->getChildByIndex(1),
        $foreach_expr->getChildByIndex(2),
      );
      foreach ($possible_used_vars as $var) {
        if ($var->getTypeName() == 'n_EMPTY') {
          continue;
        }
        $name = $var->getConcreteString();
        $name = trim($name, '&'); // Get rid of ref silliness.
        $var_map[$name] = true;
      }

      $used_vars[$foreach_loop->getID()] = $var_map;
    }

    $all_loops = $for_loops->add($foreach_loops);
    foreach ($all_loops as $loop) {
      $child_for_loops = $loop->selectDescendantsOfType('n_FOR');
      $child_foreach_loops = $loop->selectDescendantsOfType('n_FOREACH');
      $child_loops = $child_for_loops->add($child_foreach_loops);

      $outer_vars = $used_vars[$loop->getID()];
      foreach ($child_loops as $inner_loop) {
        $inner_vars = $used_vars[$inner_loop->getID()];
        $shared = array_intersect_key($outer_vars, $inner_vars);
        if ($shared) {
          $shared_desc = implode(', ', array_keys($shared));
          $this->raiseLintAtNode(
            $inner_loop->getChildByIndex(0),
            self::LINT_REUSED_ITERATORS,
            "This loop reuses iterator variables ({$shared_desc}) from an ".
            "outer loop. You might be clobbering the outer iterator. Change ".
            "the inner loop to use a different iterator name.");
        }
      }
    }
  }

  private function getConcreteVariableString($var) {
    $concrete = $var->getConcreteString();
    // Strip off curly braces as in $obj->{$property}.
    $concrete = trim($concrete, '{}');
    return $concrete;
  }

  protected function lintNamingConventions($root) {
    $ifaces = $root->selectDescendantsOfType('n_INTERFACE_DECLARATION');
    foreach ($ifaces as $iface) {
      $name_token = $iface->getChildByIndex(1);
      $name_string = $name_token->getConcreteString();
      if (!$this->isUpperCamelCase($name_string)) {
        $this->raiseLintAtNode(
          $name_token,
          self::LINT_NAMING_CONVENTIONS,
          'Follow naming conventions: interfaces should be named using '.
          'UpperCamelCase.');
      }
    }


    $functions = $root->selectDescendantsOfType('n_FUNCTION_DECLARATION');
    foreach ($functions as $function) {
      $name_token = $function->getChildByIndex(2);
      if ($name_token->getTypeName() == 'n_EMPTY') {
        // Unnamed closure.
        continue;
      }
      $name_string = $name_token->getConcreteString();
      if (!$this->isLowerCamelCase($name_string)) {
        $this->raiseLintAtNode(
          $name_token,
          self::LINT_NAMING_CONVENTIONS,
          'Follow naming conventions: functions should be named using '.
          'lowerCamelCase.');
      }
    }


    $methods = $root->selectDescendantsOfType('n_METHOD_DECLARATION');
    foreach ($methods as $method) {
      $name_token = $method->getChildByIndex(2);
      $name_string = $name_token->getConcreteString();
      if (!$this->isLowerCamelCase($name_string)) {
        $this->raiseLintAtNode(
          $name_token,
          self::LINT_NAMING_CONVENTIONS,
          'Follow naming conventions: methods should be named using '.
          'lowerCamelCase.');
      }
    }


    $params = $root->selectDescendantsOfType('n_DECLARATION_PARAMETER_LIST');
    foreach ($params as $param_list) {
      foreach ($param_list->getChildren() as $param) {
        $name_token = $param->getChildByIndex(1);
        $name_string = $name_token->getConcreteString();
        if (!$this->isLowercaseWithUnderscores($name_string)) {
          $this->raiseLintAtNode(
            $name_token,
            self::LINT_NAMING_CONVENTIONS,
            'Follow naming conventions: parameters should be named using '.
            'lowercase_with_underscores.');
        }
      }
    }


    $constants = $root->selectDescendantsOfType(
      'n_CLASS_CONSTANT_DECLARATION_LIST');
    foreach ($constants as $constant_list) {
      foreach ($constant_list->getChildren() as $constant) {
        $name_token = $constant->getChildByIndex(0);
        $name_string = $name_token->getConcreteString();
        if (!$this->isUppercaseWithUnderscores($name_string)) {
          $this->raiseLintAtNode(
            $name_token,
            self::LINT_NAMING_CONVENTIONS,
            'Follow naming conventions: class constants should be named using '.
            'UPPERCASE_WITH_UNDERSCORES.');
        }
      }
    }

    $props = $root->selectDescendantsOfType('n_CLASS_MEMBER_DECLARATION_LIST');
    foreach ($props as $prop_list) {
      foreach ($prop_list->getChildren() as $prop) {
        if ($prop->getTypeName() == 'n_CLASS_MEMBER_MODIFIER_LIST') {
          continue;
        }
        $name_token = $prop->getChildByIndex(0);
        $name_string = $name_token->getConcreteString();
        if (!$this->isLowercaseWithUnderscores($name_string)) {
          $this->raiseLintAtNode(
            $name_token,
            self::LINT_NAMING_CONVENTIONS,
            'Follow naming conventions: class properties should be named '.
            'using lowercase_with_underscores.');
        }
      }
    }
  }

  protected function isUpperCamelCase($str) {
    return preg_match('/^[A-Z][A-Za-z0-9]*$/', $str);
  }

  protected function isLowerCamelCase($str) {
    //  Allow initial "__" for magic methods like __construct; we could also
    //  enumerate these explicitly.
    return preg_match('/^\$?(?:__)?[a-z][A-Za-z0-9]*$/', $str);
  }

  protected function isUppercaseWithUnderscores($str) {
    return preg_match('/^[A-Z0-9_]+$/', $str);
  }

  protected function isLowercaseWithUnderscores($str) {
    return preg_match('/^[&]?\$?[a-z0-9_]+$/', $str);
  }

  protected function isLowercaseWithXHP($str) {
    return preg_match('/^:[a-z0-9_:-]+$/', $str);
  }

  protected function lintSurpriseConstructors($root) {
    $classes = $root->selectDescendantsOfType('n_CLASS_DECLARATION');
    foreach ($classes as $class) {
      $class_name = $class->getChildByIndex(1)->getConcreteString();
      $methods = $class->selectDescendantsOfType('n_METHOD_DECLARATION');
      foreach ($methods as $method) {
        $method_name_token = $method->getChildByIndex(2);
        $method_name = $method_name_token->getConcreteString();
        if (strtolower($class_name) == strtolower($method_name)) {
          $this->raiseLintAtNode(
            $method_name_token,
            self::LINT_IMPLICIT_CONSTRUCTOR,
            'Name constructors __construct() explicitly. This method is a '.
            'constructor because it has the same name as the class it is '.
            'defined in.');
        }
      }
    }
  }

  protected function lintParenthesesShouldHugExpressions($root) {
    $calls = $root->selectDescendantsOfType('n_CALL_PARAMETER_LIST');
    $controls = $root->selectDescendantsOfType('n_CONTROL_CONDITION');
    $fors = $root->selectDescendantsOfType('n_FOR_EXPRESSION');
    $foreach = $root->selectDescendantsOfType('n_FOREACH_EXPRESSION');
    $decl = $root->selectDescendantsOfType('n_DECLARATION_PARAMETER_LIST');

    $all_paren_groups = $calls
      ->add($controls)
      ->add($fors)
      ->add($foreach)
      ->add($decl);
    foreach ($all_paren_groups as $group) {
      $tokens = $group->getTokens();

      $token_o = array_shift($tokens);
      $token_c = array_pop($tokens);
      if ($token_o->getTypeName() != '(') {
        throw new Exception('Expected open paren!');
      }
      if ($token_c->getTypeName() != ')') {
        throw new Exception('Expected close paren!');
      }

      $nonsem_o = $token_o->getNonsemanticTokensAfter();
      $nonsem_c = $token_c->getNonsemanticTokensBefore();

      if (!$nonsem_o) {
        continue;
      }

      $raise = array();

      $string_o = implode('', mpull($nonsem_o, 'getValue'));
      if (preg_match('/^[ ]+$/', $string_o)) {
        $raise[] = array($nonsem_o, $string_o);
      }

      if ($nonsem_o !== $nonsem_c) {
        $string_c = implode('', mpull($nonsem_c, 'getValue'));
        if (preg_match('/^[ ]+$/', $string_c)) {
          $raise[] = array($nonsem_c, $string_c);
        }
      }

      foreach ($raise as $warning) {
        list($tokens, $string) = $warning;
        $this->raiseLintAtOffset(
          reset($tokens)->getOffset(),
          self::LINT_FORMATTING_CONVENTIONS,
          'Parentheses should hug their contents.',
          $string,
          '');
      }
    }
  }

  protected function lintSpaceIndent($root) {
    $new_statement = true;
    foreach ($root->getTokens() as $id => $token) {
      $token_type = $token->getTypeName();
      if ($new_statement && $token_type == 'T_WHITESPACE' && strpos($token->getValue(), '  ') !== false) {
        $this->raiseLintAtToken(
          $token,
          self::LINT_FORMATTING_CONVENTIONS,
          'Please configure your editor to use tabs for indentation.',
          $token->getValue());
      } else {
        $new_statement = in_array($token_type, array('T_OPEN_TAG', ';', '}', '{'));
      }
    }
  }

  protected function lintSpaceAfterControlStatementKeywords($root) {
    foreach ($root->getTokens() as $id => $token) {
      switch ($token->getTypeName()) {
        case 'T_IF':
        case 'T_ELSE':
        case 'T_FOR':
        case 'T_FOREACH':
        case 'T_WHILE':
        case 'T_DO':
        case 'T_SWITCH':
          $after = $token->getNonsemanticTokensAfter();
          if (empty($after)) {
            $this->raiseLintAtToken(
              $token,
              self::LINT_FORMATTING_CONVENTIONS,
              'Convention: put a space after control statements.',
              $token->getValue().' ');
          }
          break;
      }
    }
  }

  protected function lintSpaceAroundBinaryOperators($root) {
    $expressions = $root->selectDescendantsOfType('n_BINARY_EXPRESSION');
    foreach ($expressions as $expression) {
      $operator = $expression->getChildByIndex(1);
      $operator_value = $operator->getConcreteString();
      if ($operator_value == '.') {
        // TODO: implement this check
        continue;
      } else {
        list($before, $after) = $operator->getSurroundingNonsemanticTokens();

        $replace = null;
        if (empty($before) && empty($after)) {
          $replace = " {$operator_value} ";
        } else if (empty($before)) {
          $replace = " {$operator_value}";
        } else if (empty($after)) {
          $replace = "{$operator_value} ";
        }

        if ($replace !== null) {
          $this->raiseLintAtNode(
            $operator,
            self::LINT_FORMATTING_CONVENTIONS,
            'Convention: logical and arithmetic operators should be '.
            'surrounded by whitespace.',
            $replace);
        }
      }
    }
  }

  protected function lintDynamicDefines($root) {
    $calls = $root->selectDescendantsOfType('n_FUNCTION_CALL');
    foreach ($calls as $call) {
      $name = $call->getChildByIndex(0)->getConcreteString();
      if (strtolower($name) == 'define') {
        $parameter_list = $call->getChildOfType(1, 'n_CALL_PARAMETER_LIST');
        $defined = $parameter_list->getChildByIndex(0);
        if (!$defined->isStaticScalar()) {
          $this->raiseLintAtNode(
            $defined,
            self::LINT_DYNAMIC_DEFINE,
            'First argument to define() must be a string literal.');
        }
      }
    }
  }

  protected function lintUseOfThisInStaticMethods($root) {
    $classes = $root->selectDescendantsOfType('n_CLASS_DECLARATION');
    foreach ($classes as $class) {
      $methods = $class->selectDescendantsOfType('n_METHOD_DECLARATION');
      foreach ($methods as $method) {

        $attributes = $method
          ->getChildByIndex(0, 'n_METHOD_MODIFIER_LIST')
          ->selectDescendantsOfType('n_STRING');

        $method_is_static = false;
        $method_is_abstract = false;
        foreach ($attributes as $attribute) {
          if (strtolower($attribute->getConcreteString()) == 'static') {
            $method_is_static = true;
          }
          if (strtolower($attribute->getConcreteString()) == 'abstract') {
            $method_is_abstract = true;
          }
        }

        if ($method_is_abstract) {
          continue;
        }

        if (!$method_is_static) {
          continue;
        }

        $body = $method->getChildOfType(5, 'n_STATEMENT_LIST');

        $variables = $body->selectDescendantsOfType('n_VARIABLE');
        foreach ($variables as $variable) {
          if ($method_is_static &&
              strtolower($variable->getConcreteString()) == '$this') {
            $this->raiseLintAtNode(
              $variable,
              self::LINT_STATIC_THIS,
              'You can not reference "$this" inside a static method.');
          }
        }
      }
    }
  }

  /**
   * preg_quote() takes two arguments, but the second one is optional because
   * PHP is awesome.  If you don't pass a second argument, you're probably
   * going to get something wrong.
   */
  protected function lintPregQuote($root) {
    $function_calls = $root->selectDescendantsOfType('n_FUNCTION_CALL');
    foreach ($function_calls as $call) {
      $name = $call->getChildByIndex(0)->getConcreteString();
      if (strtolower($name) === 'preg_quote') {
        $parameter_list = $call->getChildOfType(1, 'n_CALL_PARAMETER_LIST');
        if (count($parameter_list->getChildren()) !== 2) {
          $this->raiseLintAtNode(
            $call,
            self::LINT_PREG_QUOTE_MISUSE,
            'You should always pass two arguments to preg_quote(), so that ' .
            'preg_quote() knows which delimiter to escape.');
        }
      }
    }
  }

  /**
   * Exit is parsed as an expression, but using it as such is almost always
   * wrong. That is, this is valid:
   *
   *    strtoupper(33 * exit - 6);
   *
   * When exit is used as an expression, it causes the program to terminate with
   * exit code 0. This is likely not what is intended; these statements have
   * different effects:
   *
   *    exit(-1);
   *    exit -1;
   *
   * The former exits with a failure code, the latter with a success code!
   */
  protected function lintExitExpressions($root) {
    $unaries = $root->selectDescendantsOfType('n_UNARY_PREFIX_EXPRESSION');
    foreach ($unaries as $unary) {
      $operator = $unary->getChildByIndex(0)->getConcreteString();
      if (strtolower($operator) == 'exit') {
        if ($unary->getParentNode()->getTypeName() != 'n_STATEMENT') {
          $this->raiseLintAtNode(
            $unary,
            self::LINT_EXIT_EXPRESSION,
            "Use exit as a statement, not an expression.");
        }
      }
    }
  }

  private function lintArrayIndexWhitespace($root) {
    $indexes = $root->selectDescendantsOfType('n_INDEX_ACCESS');
    foreach ($indexes as $index) {
      $tokens = $index->getChildByIndex(0)->getTokens();
      $last = array_pop($tokens);
      $trailing = $last->getNonsemanticTokensAfter();
      $trailing_text = implode('', mpull($trailing, 'getValue'));
      if (preg_match('/^ +$/', $trailing_text)) {
        $this->raiseLintAtOffset(
          $last->getOffset() + strlen($last->getValue()),
          self::LINT_FORMATTING_CONVENTIONS,
          'Convention: no spaces before index access.',
          $trailing_text,
          '');
      }
    }
  }

  protected function lintTODOComments($root) {
    $tokens = $root->getTokens();
    foreach ($tokens as $token) {
      if (!$token->isComment()) {
        continue;
      }

      $value = $token->getValue();
      $matches = null;
      $preg = preg_match_all(
        '/TODO/',
        $value,
        $matches,
        PREG_OFFSET_CAPTURE);

      foreach ($matches[0] as $match) {
        list($string, $offset) = $match;
        $this->raiseLintAtOffset(
          $token->getOffset() + $offset,
          self::LINT_TODO_COMMENT,
          'This comment has a TODO.',
          $string);
      }
    }
  }

  private function lintPlusOperatorOnStrings($root) {
    $binops = $root->selectDescendantsOfType('n_BINARY_EXPRESSION');
    foreach ($binops as $binop) {
      $op = $binop->getChildByIndex(1);
      if ($op->getConcreteString() != '+') {
        continue;
      }

      $left = $binop->getChildByIndex(0);
      $right = $binop->getChildByIndex(2);
      if (($left->getTypeName() == 'n_STRING_SCALAR') ||
          ($right->getTypeName() == 'n_STRING_SCALAR')) {
        $this->raiseLintAtNode(
          $binop,
          self::LINT_PLUS_OPERATOR_ON_STRINGS,
          "In PHP, '.' is the string concatenation operator, not '+'. This ".
          "expression uses '+' with a string literal as an operand.");
      }
    }
  }

  /**
   * Finds duplicate keys in array initializers, as in
   * array(1 => 'anything', 1 => 'foo').  Since the first entry is ignored,
   * this is almost certainly an error.
   */
  private function lintDuplicateKeysInArray($root) {
    $array_literals = $root->selectDescendantsOfType('n_ARRAY_LITERAL');
    foreach ($array_literals as $array_literal) {
      $nodes_by_key = array();
      $keys_warn = array();
      $list_node = $array_literal->getChildByIndex(0);
      foreach ($list_node->getChildren() as $array_entry) {
        $key_node = $array_entry->getChildByIndex(0);

        switch ($key_node->getTypeName()) {
          case 'n_STRING_SCALAR':
          case 'n_NUMERIC_SCALAR':
            // Scalars: array(1 => 'v1', '1' => 'v2');
            $key = 'scalar:'.(string)$key_node->evalStatic();
            break;

          case 'n_SYMBOL_NAME':
          case 'n_VARIABLE':
          case 'n_CLASS_STATIC_ACCESS':
            // Constants: array(CONST => 'v1', CONST => 'v2');
            // Variables: array($a => 'v1', $a => 'v2');
            // Class constants and vars: array(C::A => 'v1', C::A => 'v2');
            $key = $key_node->getTypeName().':'.$key_node->getConcreteString();
            break;

          default:
            $key = null;
        }

        if ($key !== null) {
          if (isset($nodes_by_key[$key])) {
            $keys_warn[$key] = true;
          }
          $nodes_by_key[$key][] = $key_node;
        }
      }

      foreach ($keys_warn as $key => $_) {
        foreach ($nodes_by_key[$key] as $node) {
          $this->raiseLintAtNode(
            $node,
            self::LINT_DUPLICATE_KEYS_IN_ARRAY,
            "Duplicate key in array initializer. PHP will ignore all ".
            "but the last entry.");
        }
      }
    }
  }

  protected function raiseLintAtToken(
    XHPASTToken $token,
    $code,
    $desc,
    $replace = null) {
    return $this->raiseLintAtOffset(
      $token->getOffset(),
      $code,
      $desc,
      $token->getValue(),
      $replace);
  }

  protected function raiseLintAtNode(
    XHPASTNode $node,
    $code,
    $desc,
    $replace = null) {
    return $this->raiseLintAtOffset(
      $node->getOffset(),
      $code,
      $desc,
      $node->getConcreteString(),
      $replace);
  }

}
