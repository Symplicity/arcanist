<?php

/**
 * This file is automatically generated. Use 'phutil_mapper.php' to rebuild it.
 * @generated
 */

phutil_register_library_map(array(
  'class' =>
  array(
    'ArcanistAmendWorkflow' => 'workflow/amend',
    'ArcanistApacheLicenseLinter' => 'lint/linter/apachelicense',
    'ArcanistApacheLicenseLinterTestCase' => 'lint/linter/apachelicense/__tests__',
    'ArcanistBaseUnitTestEngine' => 'unit/engine/base',
    'ArcanistBaseWorkflow' => 'workflow/base',
    'ArcanistBranchWorkflow' => 'workflow/branch',
    'ArcanistBundle' => 'parser/bundle',
    'ArcanistBundleTestCase' => 'parser/bundle/__tests__',
    'ArcanistCallConduitWorkflow' => 'workflow/call-conduit',
    'ArcanistCapabilityNotSupportedException' => 'workflow/exception/notsupported',
    'ArcanistChooseInvalidRevisionException' => 'exception',
    'ArcanistChooseNoRevisionsException' => 'exception',
    'ArcanistCommitWorkflow' => 'workflow/commit',
    'ArcanistConfiguration' => 'configuration',
    'ArcanistCoverWorkflow' => 'workflow/cover',
    'ArcanistDiffChange' => 'parser/diff/change',
    'ArcanistDiffChangeType' => 'parser/diff/changetype',
    'ArcanistDiffHunk' => 'parser/diff/hunk',
    'ArcanistDiffParser' => 'parser/diff',
    'ArcanistDiffParserTestCase' => 'parser/diff/__tests__',
    'ArcanistDiffUtils' => 'difference',
    'ArcanistDiffUtilsTestCase' => 'difference/__tests__',
    'ArcanistDiffWorkflow' => 'workflow/diff',
    'ArcanistDifferentialCommitMessage' => 'differential/commitmessage',
    'ArcanistDifferentialCommitMessageParserException' => 'differential/commitmessage',
    'ArcanistDifferentialRevisionHash' => 'differential/constants/revisionhash',
    'ArcanistDifferentialRevisionRef' => 'differential/revision',
    'ArcanistDifferentialRevisionStatus' => 'differential/constants/revisionstatus',
    'ArcanistDownloadWorkflow' => 'workflow/download',
    'ArcanistEventType' => 'events/constant/type',
    'ArcanistExportWorkflow' => 'workflow/export',
    'ArcanistFilenameLinter' => 'lint/linter/filename',
    'ArcanistGeneratedLinter' => 'lint/linter/generated',
    'ArcanistGitAPI' => 'repository/api/git',
    'ArcanistGitHookPreReceiveWorkflow' => 'workflow/git-hook-pre-receive',
    'ArcanistHelpWorkflow' => 'workflow/help',
    'ArcanistHookAPI' => 'repository/hookapi/base',
    'ArcanistInstallCertificateWorkflow' => 'workflow/install-certificate',
    'ArcanistJSHintLinter' => 'lint/linter/jshint',
    'ArcanistLiberateLintEngine' => 'lint/engine/liberate',
    'ArcanistLiberateWorkflow' => 'workflow/liberate',
    'ArcanistLicenseLinter' => 'lint/linter/license',
    'ArcanistLintEngine' => 'lint/engine/base',
    'ArcanistLintJSONRenderer' => 'lint/renderer',
    'ArcanistLintMessage' => 'lint/message',
    'ArcanistLintPatcher' => 'lint/patcher',
    'ArcanistLintRenderer' => 'lint/renderer',
    'ArcanistLintResult' => 'lint/result',
    'ArcanistLintSeverity' => 'lint/severity',
    'ArcanistLintSummaryRenderer' => 'lint/renderer',
    'ArcanistLintWorkflow' => 'workflow/lint',
    'ArcanistLinter' => 'lint/linter/base',
    'ArcanistLinterTestCase' => 'lint/linter/base/test',
    'ArcanistListWorkflow' => 'workflow/list',
    'ArcanistMarkCommittedWorkflow' => 'workflow/mark-committed',
    'ArcanistMercurialAPI' => 'repository/api/mercurial',
    'ArcanistMercurialParser' => 'repository/parser/mercurial',
    'ArcanistMercurialParserTestCase' => 'repository/parser/mercurial/__tests__',
    'ArcanistMergeWorkflow' => 'workflow/merge',
    'ArcanistNoEffectException' => 'exception/usage/noeffect',
    'ArcanistNoEngineException' => 'exception/usage/noengine',
    'ArcanistNoLintLinter' => 'lint/linter/nolint',
    'ArcanistNoLintTestCaseMisnamed' => 'lint/linter/nolint/__tests__',
    'ArcanistPEP8Linter' => 'lint/linter/pep8',
    'ArcanistPasteWorkflow' => 'workflow/paste',
    'ArcanistPatchWorkflow' => 'workflow/patch',
    'ArcanistPhutilModuleLinter' => 'lint/linter/phutilmodule',
    'ArcanistPhutilTestCase' => 'unit/engine/phutil/testcase',
    'ArcanistPhutilTestTerminatedException' => 'unit/engine/phutil/testcase/exception',
    'ArcanistPyFlakesLinter' => 'lint/linter/pyflakes',
    'ArcanistPyLintLinter' => 'lint/linter/pylint',
    'ArcanistRepositoryAPI' => 'repository/api/base',
    'ArcanistShellCompleteWorkflow' => 'workflow/shell-complete',
    'ArcanistSpellingDefaultData' => 'lint/linter/spelling',
    'ArcanistSpellingLinter' => 'lint/linter/spelling',
    'ArcanistSpellingLinterTestCase' => 'lint/linter/spelling/__tests__',
    'ArcanistSubversionAPI' => 'repository/api/subversion',
    'ArcanistSubversionHookAPI' => 'repository/hookapi/subversion',
    'ArcanistSvnHookPreCommitWorkflow' => 'workflow/svn-hook-pre-commit',
    'ArcanistTextLinter' => 'lint/linter/text',
    'ArcanistTextLinterTestCase' => 'lint/linter/text/__tests__',
    'ArcanistUnitTestResult' => 'unit/result',
    'ArcanistUnitWorkflow' => 'workflow/unit',
    'ArcanistUploadWorkflow' => 'workflow/upload',
    'ArcanistUsageException' => 'exception/usage',
    'ArcanistUserAbortException' => 'exception/usage/userabort',
    'ArcanistWorkingCopyIdentity' => 'workingcopyidentity',
    'ArcanistXHPASTLintNamingHook' => 'lint/linter/xhpast/naminghook',
    'ArcanistXHPASTLinter' => 'lint/linter/xhpast',
    'ArcanistXHPASTLinterTestCase' => 'lint/linter/xhpast/__tests__',
    'BranchInfo' => 'branch',
    'ComprehensiveLintEngine' => 'lint/engine/comprehensive',
    'ExampleLintEngine' => 'lint/engine/example',
    'PHPUnitTestEngine' => 'unit/engine/php',
    'PhutilLintEngine' => 'lint/engine/phutil',
    'PhutilModuleRequirements' => 'parser/phutilmodule',
    'PhutilUnitTestEngine' => 'unit/engine/phutil',
    'PhutilUnitTestEngineTestCase' => 'unit/engine/phutil/__tests__',
    'SympArcanistLintEngine' => 'lint/engine/symp',
    'SympXHPASTLinter' => 'lint/linter/symp',
    'UnitTestableArcanistLintEngine' => 'lint/engine/test',
  ),
  'function' =>
  array(
  ),
  'requires_class' =>
  array(
    'ArcanistAmendWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistApacheLicenseLinter' => 'ArcanistLicenseLinter',
    'ArcanistApacheLicenseLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistBranchWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistBundleTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistCallConduitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistCommitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistCoverWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistDiffParserTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistDiffUtilsTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistDiffWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistDownloadWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistEventType' => 'PhutilEventType',
    'ArcanistExportWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistFilenameLinter' => 'ArcanistLinter',
    'ArcanistGeneratedLinter' => 'ArcanistLinter',
    'ArcanistGitAPI' => 'ArcanistRepositoryAPI',
    'ArcanistGitHookPreReceiveWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistHelpWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistInstallCertificateWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistJSHintLinter' => 'ArcanistLinter',
    'ArcanistLiberateLintEngine' => 'ArcanistLintEngine',
    'ArcanistLiberateWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistLicenseLinter' => 'ArcanistLinter',
    'ArcanistLintWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistLinterTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistListWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistMarkCommittedWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistMercurialAPI' => 'ArcanistRepositoryAPI',
    'ArcanistMercurialParserTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistMergeWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistNoEffectException' => 'ArcanistUsageException',
    'ArcanistNoEngineException' => 'ArcanistUsageException',
    'ArcanistNoLintLinter' => 'ArcanistLinter',
    'ArcanistNoLintTestCaseMisnamed' => 'ArcanistLinterTestCase',
    'ArcanistPEP8Linter' => 'ArcanistLinter',
    'ArcanistPasteWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistPatchWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistPhutilModuleLinter' => 'ArcanistLinter',
    'ArcanistPyFlakesLinter' => 'ArcanistLinter',
    'ArcanistPyLintLinter' => 'ArcanistLinter',
    'ArcanistShellCompleteWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistSpellingLinter' => 'ArcanistLinter',
    'ArcanistSpellingLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistSubversionAPI' => 'ArcanistRepositoryAPI',
    'ArcanistSubversionHookAPI' => 'ArcanistHookAPI',
    'ArcanistSvnHookPreCommitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistTextLinter' => 'ArcanistLinter',
    'ArcanistTextLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistUnitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUploadWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUserAbortException' => 'ArcanistUsageException',
    'ArcanistXHPASTLinter' => 'ArcanistLinter',
    'ArcanistXHPASTLinterTestCase' => 'ArcanistLinterTestCase',
    'ComprehensiveLintEngine' => 'ArcanistLintEngine',
    'ExampleLintEngine' => 'ArcanistLintEngine',
    'PHPUnitTestEngine' => 'ArcanistBaseUnitTestEngine',
    'PhutilLintEngine' => 'ArcanistLintEngine',
    'PhutilUnitTestEngine' => 'ArcanistBaseUnitTestEngine',
    'PhutilUnitTestEngineTestCase' => 'ArcanistPhutilTestCase',
    'SympArcanistLintEngine' => 'ArcanistLintEngine',
    'SympXHPASTLinter' => 'ArcanistLinter',
    'UnitTestableArcanistLintEngine' => 'ArcanistLintEngine',
  ),
  'requires_interface' =>
  array(
  ),
));
