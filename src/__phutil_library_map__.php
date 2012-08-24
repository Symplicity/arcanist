<?php

/**
 * This file is automatically generated. Use 'arc liberate' to rebuild it.
 * @generated
 * @phutil-library-version 2
 */

phutil_register_library_map(array(
  '__library_version__' => 2,
  'class' =>
  array(
    'ArcanistAliasWorkflow' => 'workflow/ArcanistAliasWorkflow.php',
    'ArcanistAmendWorkflow' => 'workflow/ArcanistAmendWorkflow.php',
    'ArcanistAnoidWorkflow' => 'workflow/ArcanistAnoidWorkflow.php',
    'ArcanistApacheLicenseLinter' => 'lint/linter/ArcanistApacheLicenseLinter.php',
    'ArcanistApacheLicenseLinterTestCase' => 'lint/linter/__tests__/ArcanistApacheLicenseLinterTestCase.php',
    'ArcanistBaseCommitParser' => 'parser/ArcanistBaseCommitParser.php',
    'ArcanistBaseCommitParserTestCase' => 'parser/__tests__/ArcanistBaseCommitParserTestCase.php',
    'ArcanistBaseUnitTestEngine' => 'unit/engine/ArcanistBaseUnitTestEngine.php',
    'ArcanistBaseWorkflow' => 'workflow/ArcanistBaseWorkflow.php',
    'ArcanistBranchWorkflow' => 'workflow/ArcanistBranchWorkflow.php',
    'ArcanistBundle' => 'parser/ArcanistBundle.php',
    'ArcanistBundleTestCase' => 'parser/__tests__/ArcanistBundleTestCase.php',
    'ArcanistCallConduitWorkflow' => 'workflow/ArcanistCallConduitWorkflow.php',
    'ArcanistCapabilityNotSupportedException' => 'workflow/exception/ArcanistCapabilityNotSupportedException.php',
    'ArcanistChooseInvalidRevisionException' => 'exception/ArcanistChooseInvalidRevisionException.php',
    'ArcanistChooseNoRevisionsException' => 'exception/ArcanistChooseNoRevisionsException.php',
    'ArcanistCloseRevisionWorkflow' => 'workflow/ArcanistCloseRevisionWorkflow.php',
    'ArcanistCloseWorkflow' => 'workflow/ArcanistCloseWorkflow.php',
    'ArcanistCommentRemover' => 'parser/ArcanistCommentRemover.php',
    'ArcanistCommentRemoverTestCase' => 'parser/__tests__/ArcanistCommentRemoverTestCase.php',
    'ArcanistCommitWorkflow' => 'workflow/ArcanistCommitWorkflow.php',
    'ArcanistConduitLinter' => 'lint/linter/ArcanistConduitLinter.php',
    'ArcanistConfiguration' => 'configuration/ArcanistConfiguration.php',
    'ArcanistCoverWorkflow' => 'workflow/ArcanistCoverWorkflow.php',
    'ArcanistDiffChange' => 'parser/diff/ArcanistDiffChange.php',
    'ArcanistDiffChangeType' => 'parser/diff/ArcanistDiffChangeType.php',
    'ArcanistDiffHunk' => 'parser/diff/ArcanistDiffHunk.php',
    'ArcanistDiffParser' => 'parser/ArcanistDiffParser.php',
    'ArcanistDiffParserTestCase' => 'parser/__tests__/ArcanistDiffParserTestCase.php',
    'ArcanistDiffUtils' => 'difference/ArcanistDiffUtils.php',
    'ArcanistDiffUtilsTestCase' => 'difference/__tests__/ArcanistDiffUtilsTestCase.php',
    'ArcanistDiffWorkflow' => 'workflow/ArcanistDiffWorkflow.php',
    'ArcanistDifferentialCommitMessage' => 'differential/ArcanistDifferentialCommitMessage.php',
    'ArcanistDifferentialCommitMessageParserException' => 'differential/ArcanistDifferentialCommitMessageParserException.php',
    'ArcanistDifferentialRevisionHash' => 'differential/constants/ArcanistDifferentialRevisionHash.php',
    'ArcanistDifferentialRevisionStatus' => 'differential/constants/ArcanistDifferentialRevisionStatus.php',
    'ArcanistDownloadWorkflow' => 'workflow/ArcanistDownloadWorkflow.php',
    'ArcanistEventType' => 'events/constant/ArcanistEventType.php',
    'ArcanistExportWorkflow' => 'workflow/ArcanistExportWorkflow.php',
    'ArcanistFilenameLinter' => 'lint/linter/ArcanistFilenameLinter.php',
    'ArcanistFlagWorkflow' => 'workflow/ArcanistFlagWorkflow.php',
    'ArcanistGeneratedLinter' => 'lint/linter/ArcanistGeneratedLinter.php',
    'ArcanistGetConfigWorkflow' => 'workflow/ArcanistGetConfigWorkflow.php',
    'ArcanistGitAPI' => 'repository/api/ArcanistGitAPI.php',
    'ArcanistGitHookPreReceiveWorkflow' => 'workflow/ArcanistGitHookPreReceiveWorkflow.php',
    'ArcanistHelpWorkflow' => 'workflow/ArcanistHelpWorkflow.php',
    'ArcanistHgClientChannel' => 'hgdaemon/ArcanistHgClientChannel.php',
    'ArcanistHgProxyClient' => 'hgdaemon/ArcanistHgProxyClient.php',
    'ArcanistHgProxyServer' => 'hgdaemon/ArcanistHgProxyServer.php',
    'ArcanistHgServerChannel' => 'hgdaemon/ArcanistHgServerChannel.php',
    'ArcanistHookAPI' => 'repository/hookapi/ArcanistHookAPI.php',
    'ArcanistInlinesWorkflow' => 'workflow/ArcanistInlinesWorkflow.php',
    'ArcanistInstallCertificateWorkflow' => 'workflow/ArcanistInstallCertificateWorkflow.php',
    'ArcanistJSHintLinter' => 'lint/linter/ArcanistJSHintLinter.php',
    'ArcanistLandWorkflow' => 'workflow/ArcanistLandWorkflow.php',
    'ArcanistLiberateWorkflow' => 'workflow/ArcanistLiberateWorkflow.php',
    'ArcanistLicenseLinter' => 'lint/linter/ArcanistLicenseLinter.php',
    'ArcanistLintConsoleRenderer' => 'lint/renderer/ArcanistLintConsoleRenderer.php',
    'ArcanistLintEngine' => 'lint/engine/ArcanistLintEngine.php',
    'ArcanistLintJSONRenderer' => 'lint/renderer/ArcanistLintJSONRenderer.php',
    'ArcanistLintLikeCompilerRenderer' => 'lint/renderer/ArcanistLintLikeCompilerRenderer.php',
    'ArcanistLintMessage' => 'lint/ArcanistLintMessage.php',
    'ArcanistLintPatcher' => 'lint/ArcanistLintPatcher.php',
    'ArcanistLintRenderer' => 'lint/renderer/ArcanistLintRenderer.php',
    'ArcanistLintResult' => 'lint/ArcanistLintResult.php',
    'ArcanistLintSeverity' => 'lint/ArcanistLintSeverity.php',
    'ArcanistLintSummaryRenderer' => 'lint/renderer/ArcanistLintSummaryRenderer.php',
    'ArcanistLintWorkflow' => 'workflow/ArcanistLintWorkflow.php',
    'ArcanistLinter' => 'lint/linter/ArcanistLinter.php',
    'ArcanistLinterTestCase' => 'lint/linter/__tests__/ArcanistLinterTestCase.php',
    'ArcanistListWorkflow' => 'workflow/ArcanistListWorkflow.php',
    'ArcanistMarkCommittedWorkflow' => 'workflow/ArcanistMarkCommittedWorkflow.php',
    'ArcanistMercurialAPI' => 'repository/api/ArcanistMercurialAPI.php',
    'ArcanistMercurialParser' => 'repository/parser/ArcanistMercurialParser.php',
    'ArcanistMercurialParserTestCase' => 'repository/parser/__tests__/ArcanistMercurialParserTestCase.php',
    'ArcanistNoEffectException' => 'exception/usage/ArcanistNoEffectException.php',
    'ArcanistNoEngineException' => 'exception/usage/ArcanistNoEngineException.php',
    'ArcanistNoLintLinter' => 'lint/linter/ArcanistNoLintLinter.php',
    'ArcanistNoLintTestCaseMisnamed' => 'lint/linter/__tests__/ArcanistNoLintTestCase.php',
    'ArcanistPEP8Linter' => 'lint/linter/ArcanistPEP8Linter.php',
    'ArcanistPasteWorkflow' => 'workflow/ArcanistPasteWorkflow.php',
    'ArcanistPatchWorkflow' => 'workflow/ArcanistPatchWorkflow.php',
    'ArcanistPhpcsLinter' => 'lint/linter/ArcanistPhpcsLinter.php',
    'ArcanistPhutilLibraryLinter' => 'lint/linter/ArcanistPhutilLibraryLinter.php',
    'ArcanistPhutilTestCase' => 'unit/engine/phutil/ArcanistPhutilTestCase.php',
    'ArcanistPhutilTestCaseTestCase' => 'unit/engine/phutil/testcase/ArcanistPhutilTestCaseTestCase.php',
    'ArcanistPhutilTestSkippedException' => 'unit/engine/phutil/testcase/ArcanistPhutilTestSkippedException.php',
    'ArcanistPhutilTestTerminatedException' => 'unit/engine/phutil/testcase/ArcanistPhutilTestTerminatedException.php',
    'ArcanistPyFlakesLinter' => 'lint/linter/ArcanistPyFlakesLinter.php',
    'ArcanistPyLintLinter' => 'lint/linter/ArcanistPyLintLinter.php',
    'ArcanistRepositoryAPI' => 'repository/api/ArcanistRepositoryAPI.php',
    'ArcanistScriptAndRegexLinter' => 'lint/linter/ArcanistScriptAndRegexLinter.php',
    'ArcanistSetConfigWorkflow' => 'workflow/ArcanistSetConfigWorkflow.php',
    'ArcanistSettings' => 'configuration/ArcanistSettings.php',
    'ArcanistShellCompleteWorkflow' => 'workflow/ArcanistShellCompleteWorkflow.php',
    'ArcanistSingleLintEngine' => 'lint/engine/ArcanistSingleLintEngine.php',
    'ArcanistSpellingDefaultData' => 'lint/linter/ArcanistSpellingDefaultData.php',
    'ArcanistSpellingLinter' => 'lint/linter/ArcanistSpellingLinter.php',
    'ArcanistSpellingLinterTestCase' => 'lint/linter/__tests__/ArcanistSpellingLinterTestCase.php',
    'ArcanistSubversionAPI' => 'repository/api/ArcanistSubversionAPI.php',
    'ArcanistSubversionHookAPI' => 'repository/hookapi/ArcanistSubversionHookAPI.php',
    'ArcanistSvnHookPreCommitWorkflow' => 'workflow/ArcanistSvnHookPreCommitWorkflow.php',
    'ArcanistTasksWorkflow' => 'workflow/ArcanistTasksWorkflow.php',
    'ArcanistTextLinter' => 'lint/linter/ArcanistTextLinter.php',
    'ArcanistTextLinterTestCase' => 'lint/linter/__tests__/ArcanistTextLinterTestCase.php',
    'ArcanistTodoWorkflow' => 'workflow/ArcanistTodoWorkflow.php',
    'ArcanistUncommittedChangesException' => 'exception/usage/ArcanistUncommittedChangesException.php',
    'ArcanistUnitTestResult' => 'unit/ArcanistUnitTestResult.php',
    'ArcanistUnitWorkflow' => 'workflow/ArcanistUnitWorkflow.php',
    'ArcanistUpgradeWorkflow' => 'workflow/ArcanistUpgradeWorkflow.php',
    'ArcanistUploadWorkflow' => 'workflow/ArcanistUploadWorkflow.php',
    'ArcanistUsageException' => 'exception/ArcanistUsageException.php',
    'ArcanistUserAbortException' => 'exception/usage/ArcanistUserAbortException.php',
    'ArcanistWhichWorkflow' => 'workflow/ArcanistWhichWorkflow.php',
    'ArcanistWorkingCopyIdentity' => 'workingcopyidentity/ArcanistWorkingCopyIdentity.php',
    'ArcanistXHPASTLintNamingHook' => 'lint/linter/xhpast/ArcanistXHPASTLintNamingHook.php',
    'ArcanistXHPASTLintNamingHookTestCase' => 'lint/linter/xhpast/__tests__/ArcanistXHPASTLintNamingHookTestCase.php',
    'ArcanistXHPASTLinter' => 'lint/linter/ArcanistXHPASTLinter.php',
    'ArcanistXHPASTLinterTestCase' => 'lint/linter/__tests__/ArcanistXHPASTLinterTestCase.php',
    'ComprehensiveLintEngine' => 'lint/engine/ComprehensiveLintEngine.php',
    'ExampleLintEngine' => 'lint/engine/ExampleLintEngine.php',
    'NoseTestEngine' => 'unit/engine/NoseTestEngine.php',
    'PhpunitTestEngine' => 'unit/engine/PhpunitTestEngine.php',
    'PhutilLintEngine' => 'lint/engine/PhutilLintEngine.php',
    'PhutilUnitTestEngine' => 'unit/engine/PhutilUnitTestEngine.php',
    'PhutilUnitTestEngineTestCase' => 'unit/engine/__tests__/PhutilUnitTestEngineTestCase.php',
    'SympArcanistLintEngine' => 'lint/engine/symp',
    'SympXHPASTLinter' => 'lint/linter/symp',
    'UnitTestableArcanistLintEngine' => 'lint/engine/UnitTestableArcanistLintEngine.php',
  ),
  'function' =>
  array(
  ),
  'xmap' =>
  array(
    'ArcanistAliasWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistAmendWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistAnoidWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistApacheLicenseLinter' => 'ArcanistLicenseLinter',
    'ArcanistApacheLicenseLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistBaseCommitParserTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistBranchWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistBundleTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistCallConduitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistCapabilityNotSupportedException' => 'Exception',
    'ArcanistChooseInvalidRevisionException' => 'Exception',
    'ArcanistChooseNoRevisionsException' => 'Exception',
    'ArcanistCloseRevisionWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistCloseWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistCommentRemoverTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistCommitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistConduitLinter' => 'ArcanistLinter',
    'ArcanistCoverWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistDiffParserTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistDiffUtilsTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistDiffWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistDifferentialCommitMessageParserException' => 'Exception',
    'ArcanistDownloadWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistEventType' => 'PhutilEventType',
    'ArcanistExportWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistFilenameLinter' => 'ArcanistLinter',
    'ArcanistFlagWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistGeneratedLinter' => 'ArcanistLinter',
    'ArcanistGetConfigWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistGitAPI' => 'ArcanistRepositoryAPI',
    'ArcanistGitHookPreReceiveWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistHelpWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistHgClientChannel' => 'PhutilProtocolChannel',
    'ArcanistHgServerChannel' => 'PhutilProtocolChannel',
    'ArcanistInlinesWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistInstallCertificateWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistJSHintLinter' => 'ArcanistLinter',
    'ArcanistLandWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistLiberateWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistLicenseLinter' => 'ArcanistLinter',
    'ArcanistLintConsoleRenderer' => 'ArcanistLintRenderer',
    'ArcanistLintJSONRenderer' => 'ArcanistLintRenderer',
    'ArcanistLintLikeCompilerRenderer' => 'ArcanistLintRenderer',
    'ArcanistLintSummaryRenderer' => 'ArcanistLintRenderer',
    'ArcanistLintWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistLinterTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistListWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistMarkCommittedWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistMercurialAPI' => 'ArcanistRepositoryAPI',
    'ArcanistMercurialParserTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistNoEffectException' => 'ArcanistUsageException',
    'ArcanistNoEngineException' => 'ArcanistUsageException',
    'ArcanistNoLintLinter' => 'ArcanistLinter',
    'ArcanistNoLintTestCaseMisnamed' => 'ArcanistLinterTestCase',
    'ArcanistPEP8Linter' => 'ArcanistLinter',
    'ArcanistPasteWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistPatchWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistPhpcsLinter' => 'ArcanistLinter',
    'ArcanistPhutilLibraryLinter' => 'ArcanistLinter',
    'ArcanistPhutilTestCaseTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistPhutilTestSkippedException' => 'Exception',
    'ArcanistPhutilTestTerminatedException' => 'Exception',
    'ArcanistPyFlakesLinter' => 'ArcanistLinter',
    'ArcanistPyLintLinter' => 'ArcanistLinter',
    'ArcanistScriptAndRegexLinter' => 'ArcanistLinter',
    'ArcanistSetConfigWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistShellCompleteWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistSingleLintEngine' => 'ArcanistLintEngine',
    'ArcanistSpellingLinter' => 'ArcanistLinter',
    'ArcanistSpellingLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistSubversionAPI' => 'ArcanistRepositoryAPI',
    'ArcanistSubversionHookAPI' => 'ArcanistHookAPI',
    'ArcanistSvnHookPreCommitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistTasksWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistTextLinter' => 'ArcanistLinter',
    'ArcanistTextLinterTestCase' => 'ArcanistLinterTestCase',
    'ArcanistTodoWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUncommittedChangesException' => 'ArcanistUsageException',
    'ArcanistUnitWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUpgradeWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUploadWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistUsageException' => 'Exception',
    'ArcanistUserAbortException' => 'ArcanistUsageException',
    'ArcanistWhichWorkflow' => 'ArcanistBaseWorkflow',
    'ArcanistXHPASTLintNamingHookTestCase' => 'ArcanistPhutilTestCase',
    'ArcanistXHPASTLinter' => 'ArcanistLinter',
    'ArcanistXHPASTLinterTestCase' => 'ArcanistLinterTestCase',
    'ComprehensiveLintEngine' => 'ArcanistLintEngine',
    'ExampleLintEngine' => 'ArcanistLintEngine',
    'PHPUnitTestEngine' => 'ArcanistBaseUnitTestEngine',
    'NoseTestEngine' => 'ArcanistBaseUnitTestEngine',
    'PhpunitTestEngine' => 'ArcanistBaseUnitTestEngine',
    'PhutilLintEngine' => 'ArcanistLintEngine',
    'PhutilUnitTestEngine' => 'ArcanistBaseUnitTestEngine',
    'PhutilUnitTestEngineTestCase' => 'ArcanistPhutilTestCase',
    'SympArcanistLintEngine' => 'ArcanistLintEngine',
    'SympXHPASTLinter' => 'ArcanistLinter',
    'UnitTestableArcanistLintEngine' => 'ArcanistLintEngine',
  ),
));
