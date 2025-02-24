<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
	{
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FpNewsletter',
            'Pi1',
            [
                \Fixpunkt\FpNewsletter\Controller\LogController::class => 'new, create, resend, subscribeExt, unsubscribe, unsubscribeDM, unsubscribeLux, delete, verify, verifyUnsubscribe, form, list'
            ],
            [
                \Fixpunkt\FpNewsletter\Controller\LogController::class => 'new, create, resend, subscribeExt, unsubscribe, unsubscribeDM, unsubscribeLux, delete, verify, verifyUnsubscribe'
            ]
        );

    	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    		'mod {
    			wizards.newContentElement.wizardItems.plugins {
    				elements {
    					fpnl {
    						iconIdentifier = fp_newsletter-plugin-pi1
    						title = LLL:EXT:fp_newsletter/Resources/Private/Language/locallang_db.xlf:tx_fp_newsletter_domain_model_pi1
    						description = LLL:EXT:fp_newsletter/Resources/Private/Language/locallang_db.xlf:tx_fp_newsletter_domain_model_pi1.description
    						tt_content_defValues {
    							CType = list
    							list_type = fpnewsletter_pi1
    						}
    					}
    				}
    				show = *
    			}
    	   }'
    	);
    	
    	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    	
    	$iconRegistry->registerIcon(
    	    'fp_newsletter-plugin-pi1',
    	    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    	    ['source' => 'EXT:fp_newsletter/Resources/Public/Icons/fp_newsletter-plugin.png']
    	);
    }
);

// Plugin Preview
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['fp_newsletter']
    = \Fixpunkt\FpNewsletter\Hooks\PageLayoutViewHook::class;
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('mod.web_layout.tt_content.preview.list.fpnewsletter_pi1 = EXT:fp_newsletter/Resources/Private/Templates/Backend/PluginPreview.html');

if (empty($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\\CMS\\Scheduler\\Task\\TableGarbageCollectionTask']['options']['tables']['tx_fpnewsletter_domain_model_log'])) {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['TYPO3\\CMS\\Scheduler\\Task\\TableGarbageCollectionTask']['options']['tables']['tx_fpnewsletter_domain_model_log'] = array(
		'dateField' => 'tstamp',
		'expirePeriod' => '180'
	);
}
