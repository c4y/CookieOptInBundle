<?php
use Contao\StringUtil;
use HeimrichHannot\FieldpaletteBundle\Model\FieldPaletteModel;

/********************************************************* Revoke Modul ***********************************************/

$GLOBALS['TL_CSS'][] = 'bundles/netzhirschcookieoptin/netzhirschCookieOptInBackend.css|static';

$GLOBALS['TL_DCA']['tl_module']['palettes']['cookieOptInRevoke'] =
	'name,
	type,
	revokeButton,
	align,
	space,
	cssID,
	templateRevoke'
;

$GLOBALS['TL_DCA']['tl_module']['fields']['revokeButton'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['revokeButton'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval' => [
		'mandatory' => true,
		'tl_class' => 'w50 clr',
		'maxlength' => 255,
	],
	'sql' => "varchar(255) NOT NULL default 'Cookie-Entscheidung ändern'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['templateRevoke'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['templateRevoke'],
	'exclude'   => true,
	'inputType' => 'select',
	'options' => $this->getTemplateGroup('mod_cookie_opt_in_revoke'),
	'eval' => [
		'tl_class'  =>  'w50 clr',
	],
	'sql' => "varchar(64) NULL default '' ",
];

/********************************************************* Ende Revoke Modul ******************************************/

/********************************************************* Bar Modul **************************************************/

$GLOBALS['TL_DCA']['tl_module']['palettes']['cookieOptInBar']   = '
	name
	,type
	;headlineCookieOptInBar
	,questionHint
	,saveButton
	,saveAllButton
	;infoHint
	;align
	,space
	,cssID
	;cookieGroups
	,defaultTools
	,cookieTools
	,otherScripts
	;cookieExpiredTime
	;privacyPolicy
	,impress
	,excludePages
	;respectToNotTrack
	;templateBar
	,cssTemplateStyle
	,defaultCss
	;isNewCookieVersion
';

// setCookieVersion check for right modul
$GLOBALS['TL_DCA']['tl_module']['config']['onsubmit_callback'] = [['tl_module_extend','setCookieVersion']];

$GLOBALS['TL_DCA']['tl_module']['fields']['headlineCookieOptInBar'] = $GLOBALS['TL_DCA']['tl_module']['fields']['headline'];


$GLOBALS['TL_DCA']['tl_module']['fields']['headlineCookieOptInBar']['load_callback'] = [['tl_module_extend','getDefaultHeadline']];

$GLOBALS['TL_DCA']['tl_module']['fields']['questionHint'] = [
		'label' => &$GLOBALS['TL_LANG']['tl_module']['questionHint'],
		'explanation' => &$GLOBALS['TL_LANG']['tl_module']['questionHint'],
		'exclude'   => true,
		'inputType' => 'textarea',
		'eval' => ['tl_class'=>'long clr'],
		'sql' => "text NULL default ''",
		'load_callback' => [['tl_module_extend','getDefaultQuestionHintDefault']]
];

$GLOBALS['TL_DCA']['tl_module']['fields']['saveButton'] = [
		'label' => &$GLOBALS['TL_LANG']['tl_module']['saveButton'],
		'exclude'   => true,
		'inputType' => 'text',
		'eval' => [
				'tl_class' => 'w50'
		],
		'sql' => "varchar(255) NOT NULL DEFAULT 'Speichern' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['saveAllButton'] = [
		'label' => &$GLOBALS['TL_LANG']['tl_module']['saveAllButton'],
		'exclude'   => true,
		'inputType' => 'text',
		'eval' => [
				'tl_class' => 'w50'
		],
		'sql' => "varchar(255) NOT NULL DEFAULT 'Alle annehmen'",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['infoHint'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['infoHint'],
	'explanation' => &$GLOBALS['TL_LANG']['tl_module']['infoHint'],
	'exclude'   => true,
	'inputType' => 'textarea',
	'eval' => ['tl_class'=>'long'],
	'default' => &$GLOBALS['TL_LANG']['tl_module']['infoHintDefault'],
	'sql' => "text  NULL default ''",
	'load_callback' => [['tl_module_extend','getDefaultInfoHintDefault']]
];

$GLOBALS['TL_DCA']['tl_module']['fields']['isNewCookieVersion'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['isNewCookieVersion'],
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval' => [
		'tl_class'  =>  'long clr',
	],
	'default' => '0',
	'sql' => "int(4) NULL",
];


$GLOBALS['TL_DCA']['tl_module']['fields']['cookieVersion'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['cookieVersion'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval' => [
		'style' => 'display:none'
	],
	'default' => '1',
	'sql' => "int(10) NULL",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cookieGroups'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['cookieGroups'],
	'exclude'   => true,
	'inputType' => 'listWizard',
	'eval' => [
		'tl_class'  =>  'long clr',
		'submitOnChange' => true,
		'doNotCopy' => true,
	],
	'sql' => "blob NULL default '' ",
	'load_callback' => [['tl_module_extend','getDefaultGroups']]
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cookieTools'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieTools'],
	'exclude'   => true,
	'inputType' => 'fieldpalette',
	'foreignKey'   => 'tl_fieldpalette.id',
	'relation'     => ['type' => 'hasMany', 'load' => 'eager'],
	'sql'          => "blob NULL",
	'load_callback' => [['tl_module_extend','getNetzhirschCookie']],
	'fieldpalette' => [
		'config' => [
			'hidePublished' => true,
			'notSortable' => true
		],
		'list'     => [
			'label' => [
				'fields' => ['cookieToolsName','cookieToolGroup'],
				'format' => '%s <span style="color:#b3b3b3;padding-left:3px">[%s]</span>',
			],
		],
		'palettes' => [
			'default' =>
				'cookieToolsName,
				cookieToolsSelect,
				cookieToolsTechnicalName,
				cookieToolsTrackingId,
				cookieToolsTrackingServerUrl,
				cookieToolsProvider,
				cookieToolsPrivacyPolicyUrl,
				cookieToolsUse,
				cookieToolGroup',
		],
		'fields' => [
			'cookieToolsName' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsName'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolsSelect' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsSelect'],
				'exclude'   => true,
				'inputType' => 'select',
				'options'   => [
					'googleAnalytics' => 'Google Analytics',
					'facebookPixel' => 'Facebook Pixel',
					'matomo' => 'Matomo',
				],
				'sql' => "varchar(32) default '' ",
			],
			'cookieToolsTechnicalName' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsTechnicalName'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolsTrackingId' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsTrackingId'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolsTrackingServerUrl' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsTrackingServerUrl'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
			],
			'cookieToolsProvider' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsProvider'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
			],
			'cookieToolsPrivacyPolicyUrl' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsPrivacyPolicyUrl'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
			],
			'cookieToolsUse' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsUse'],
				'exclude'   => true,
				'inputType' => 'textarea',
				'sql' => "text NULL default '' ",
				'eval' => [
					'mandatory' => true
				],
			],
			'cookieToolGroup' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolGroup'],
				'exclude'   => true,
				'inputType' => 'select',
				'options_callback' => ['tl_module_extend','getGroups'],
				'sql' => "varchar(255) NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			]
		],
	],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['otherScripts'] = [
	'label'     => &$GLOBALS['TL_LANG']['tl_module']['otherScripts'],
	'exclude'   => true,
	'inputType' => 'fieldpalette',
	'foreignKey'   => 'tl_fieldpalette.id',
	'relation'     => ['type' => 'hasMany', 'load' => 'eager'],
	'sql'          => "blob NULL",
	'fieldpalette' => [
		'config' => [
			'hidePublished' => true,
			'notSortable' => true,
		],
		'list'     => array
		(
			'label' => array
			(
				'fields' => ['cookieToolsName','cookieToolGroup'],
				'format' => '%s <span style="color:#b3b3b3;padding-left:3px">[%s]</span>',
			),
			'flag' => 12,
		),
		'palettes' => [
			'default' =>
				'cookieToolsProvider,
				cookieToolsUse,
				cookieToolsPrivacyPolicyUrl,
				cookieToolsTechnicalName,
				cookieToolsName,
				cookieToolGroup,
				cookieToolsCode',
		],
		'fields' => [
			'cookieToolsProvider' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsProvider'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
				'eval' => [
					'mandatory' => true
				],
			],
			'cookieToolsUse' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsUse'],
				'exclude'   => true,
				'inputType' => 'textarea',
				'sql' => "text NULL default '' ",
				'eval' => [
					'mandatory' => true
				],
			],
			'cookieToolsPrivacyPolicyUrl' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsPrivacyPolicyUrl'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
			],
			'cookieToolsTechnicalName' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsTechnicalName'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NOT NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolsName' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsName'],
				'exclude'   => true,
				'inputType' => 'text',
				'sql' => "varchar(255) NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolGroup' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolGroup'],
				'exclude'   => true,
				'inputType' => 'select',
				'options_callback' => ['tl_module_extend','getGroups'],
				'sql' => "varchar(255) NULL default '' ",
				'eval' => [
					'mandatory' => true,
				],
			],
			'cookieToolsCode' => [
				'label'     => &$GLOBALS['TL_LANG']['tl_module']['cookieToolsCode'],
				'exclude'   => true,
				'inputType' => 'textarea',
				'sql' => "varchar(255) NULL default '' ",
				'eval' => [
					'mandatory' => true,
					'allowHtml' => true,
					'rte' => 'ace',
					'preserveTags' => true,
				],
			],
		],
	],
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cookieExpiredTime'] = [
	'label' => 	&$GLOBALS['TL_LANG']['tl_module']['cookieExpiredTime'],
	'exclude'   => true,
	'inputType' => 'text',
	'eval' => [
		'mandatory' => true,
		'rgxp'=>'natural',
		'tl_class'=>'long',
		'maxval' => '99'
	],
	'default' => '1',
	'sql' => "int(2) NULL ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['privacyPolicy'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['privacyPolicy'],
	'exclude'   => true,
	'inputType' => 'pageTree',
	'eval' => [
		'tl_class'  =>  'w50',
	],
	'sql' => "varchar(3) NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['impress'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['impress'],
	'exclude'   => true,
	'inputType' => 'pageTree',
	'eval' => [
		'tl_class'  =>  'w50',
	],
	'sql' => "varchar(3) NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['excludePages'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['excludePages'],
	'exclude'   => true,
	'inputType' => 'pageTree',
	'eval' => [
		'tl_class'  =>  'long clr',
		'alwaysSave' => false,
		'fieldType'=>'checkbox',
		'multiple'=>true,
	],
	'sql' => "blob NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['respectToNotTrack'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['respectToNotTrack'],
	'exclude'   => true,
	'inputType' => 'checkbox',
	'eval' => [
		'tl_class'  =>  'long clr',
	],
	'sql' => "varchar(3) NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['defaultCss'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['defaultCss'],
	'exclude'   => true,
	'inputType' => 'checkbox',
	'default' => '1',
	'eval' => [
		'tl_class'  =>  'w50 clr',
	],
	'sql' => "varchar(255) NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['cssTemplateStyle'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['cssTemplateStyle'],
	'exclude'   => true,
	'inputType' => 'select',
	'options' => [
		'dark' => &$GLOBALS['TL_LANG']['tl_module']['cssTemplateStyle']['dark'],
		'light' => &$GLOBALS['TL_LANG']['tl_module']['cssTemplateStyle']['light'],
	],
	'eval' => [
		'tl_class'  =>  'w50 clr',
	],
	'sql' => "varchar(255) NULL default '' ",
];

$GLOBALS['TL_DCA']['tl_module']['fields']['templateBar'] = [
	'label' => &$GLOBALS['TL_LANG']['tl_module']['templateBar'],
	'exclude'   => true,
	'inputType' => 'select',
	'options' => $this->getTemplateGroup('mod_cookie_opt_in_bar'),
	'eval' => [
		'tl_class'  =>  'w50 clr',
	],
	'sql' => "varchar(64) NULL default '' ",
];

class tl_module_extend extends tl_module {
	
	public function getDefaultQuestionHintDefault($value){

		if (empty($value))
			$value = $GLOBALS['TL_LANG']['tl_module']['questionHintDefault'];

		return $value;
	}

	public function getDefaultInfoHintDefault($value){

		if (empty($value))
			$value = $GLOBALS['TL_LANG']['tl_module']['infoHintDefault'];

		return $value;
	}

	public function getDefaultGroups($value){

		if (empty($value))
			$value = ['Essenziell'];

		return $value;
	}

	public function getDefaultHeadline($value){
		if ($value == 'a:2:{s:5:"value";s:0:"";s:4:"unit";s:2:"h2";}')
			return $GLOBALS['TL_LANG']['tl_module']['headlineCookieOptInBarDefault'];
		else
			return $value;
	}
	
	public function setCookieVersion(DC_Table $dca)
	{
		$strField = $dca->__get('field');
		if ($strField == 'isNewCookieVersion') {
			$cookieOptInBarMod = ModuleModel::findOneByType('cookieOptInBar');
			if (!empty($cookieOptInBarMod->isNewCookieVersion)) {
				$cookieOptInBarMod->cookieVersion++;
				$cookieOptInBarMod->save();
			}
		}
		return $dca;
	}
	
	public function getGroups(DC_Table $dca)
	{
		$fieldPaletteModel = FieldPaletteModel::findById($dca->id);
		$modul = ModuleModel::findById($fieldPaletteModel->pid);
		$cookieToolGroups = $modul->cookieToolGroups;
		$cookieToolGroups = StringUtil::deserialize($cookieToolGroups[0]['cookieGroups']);
		if (empty($cookieToolGroups)){
			$cookieToolGroups = [
				'Essenziell',
				'Analyse',
			];
		}
		return $cookieToolGroups;
	}
	
	public function getNetzhirschCookie($fieldValue,DC_Table $dca)
	{
		$id = $dca->id;
		
		$fieldPalettes = FieldPaletteModel::findAll();
		$netzhirschCookieFieldModel = null;
		$csrfCookieFieldModel = null;
		$phpSessIdCookieFieldModel = null;
		foreach ($fieldPalettes as $fieldPalette) {
			if ($fieldPalette->cookieToolsTechnicalName == '_netzhirsch_cookie_opt_in') {
				$netzhirschCookieFieldModel = $fieldPalette;
			} elseif ($fieldPalette->cookieToolsTechnicalName == 'csrf_contao_csrf_token') {
				$csrfCookieFieldModel = $fieldPalette;
			} elseif ($fieldPalette->cookieToolsTechnicalName == 'PHPSESSID') {
				$phpSessIdCookieFieldModel = $fieldPalette;
			}

		}
		if (empty($netzhirschCookieFieldModel)) {
			$netzhirschCookieFieldModel = new FieldPaletteModel();
			
			$netzhirschCookieFieldModel->pid = $id;
			$netzhirschCookieFieldModel->ptable = 'tl_module';
			$netzhirschCookieFieldModel->pfield = 'cookieTools';
			$netzhirschCookieFieldModel->sorting = '1';
			$netzhirschCookieFieldModel->tstamp = time();
			$netzhirschCookieFieldModel->dateAdded = time();
			$netzhirschCookieFieldModel->published = '1';
			$netzhirschCookieFieldModel->cookieToolsName = 'Netzhirsch';
			$netzhirschCookieFieldModel->cookieToolsTechnicalName = '_netzhirsch_cookie_opt_in';
			$netzhirschCookieFieldModel->cookieToolsPrivacyPolicyUrl = '';
			$netzhirschCookieFieldModel->cookieToolsProvider = '';
			$netzhirschCookieFieldModel->cookieToolsTrackingId = '1';
			$netzhirschCookieFieldModel->cookieToolsSelect = 'netzhirsch';
			$netzhirschCookieFieldModel->cookieToolsUse = 'Dient zum bestimmen welche Cookie angenommen oder abgelehnt wurden';
			$netzhirschCookieFieldModel->cookieToolGroup = 'Essenziell';
			
			$netzhirschCookieFieldModel->save();
		}
		
		
		if (empty($csrfCookieFieldModel)) {
			
			$csrfCookieFieldModel = new FieldPaletteModel();
			
			$csrfCookieFieldModel->pid = $id;
			$csrfCookieFieldModel->ptable = 'tl_module';
			$csrfCookieFieldModel->pfield = 'cookieTools';
			$csrfCookieFieldModel->sorting = '1';
			$csrfCookieFieldModel->tstamp = time();
			$csrfCookieFieldModel->dateAdded = time();
			$csrfCookieFieldModel->published = '1';
			$csrfCookieFieldModel->cookieToolsName = 'Contao CSRF Token';
			$csrfCookieFieldModel->cookieToolsTechnicalName = 'csrf_contao_csrf_token';
			$csrfCookieFieldModel->cookieToolsPrivacyPolicyUrl = '';
			$csrfCookieFieldModel->cookieToolsProvider = '';
			$csrfCookieFieldModel->cookieToolsTrackingId = '1';
			$csrfCookieFieldModel->cookieToolsSelect = 'netzhirsch';
			$csrfCookieFieldModel->cookieToolsUse = 'Dient der Sicherheit der Website vor Cross-Site-Request-Forgery
		Angriffen. Nach dem Schließen des Browsers wird das Cookie wieder gelöscht';
			$csrfCookieFieldModel->cookieToolGroup = 'Essenziell';
			
			$csrfCookieFieldModel->save();
		}
		
		if (empty($phpSessIdCookieFieldModel)) {
			
			$phpSessIdCookieFieldModel = new FieldPaletteModel();
			
			$phpSessIdCookieFieldModel->pid = $id;
			$phpSessIdCookieFieldModel->ptable = 'tl_module';
			$phpSessIdCookieFieldModel->pfield = 'cookieTools';
			$phpSessIdCookieFieldModel->sorting = '1';
			$phpSessIdCookieFieldModel->tstamp = time();
			$phpSessIdCookieFieldModel->dateAdded = time();
			$phpSessIdCookieFieldModel->published = '1';
			$phpSessIdCookieFieldModel->cookieToolsName = 'PHP SESSION ID';
			$phpSessIdCookieFieldModel->cookieToolsTechnicalName = 'PHPSESSID';
			$phpSessIdCookieFieldModel->cookieToolsPrivacyPolicyUrl = '';
			$phpSessIdCookieFieldModel->cookieToolsProvider = '';
			$phpSessIdCookieFieldModel->cookieToolsTrackingId = '1';
			$phpSessIdCookieFieldModel->cookieToolsSelect = 'netzhirsch';
			$phpSessIdCookieFieldModel->cookieToolsUse = 'Cookie von PHP (Programmiersprache), PHP Daten-Identifikator.
		Enthält nur einen Verweis auf die aktuelle Sitzung. Im Browser des Nutzers werden keine Informationen
		gespeichert und dieses Cookie kann nur von der aktuellen Website genutzt werden. Dieses Cookie wird vor
		allem in Formularen benutzt, um die Benutzerfreundlichkeit zu erhöhen. In Formulare eingegebene Daten werden
		z. B. kurzzeitig gespeichert, wenn ein Eingabefehler durch den Nutzer vorliegt und dieser eine Fehlermeldung
		erhält. Ansonsten müssten alle Daten erneut eingegeben werden.';
			$phpSessIdCookieFieldModel->cookieToolGroup = 'Essenziell';
			
			$phpSessIdCookieFieldModel->save();
			
		}
		
	if (!empty($fieldValue)) {
		$fieldValues = StringUtil::deserialize($fieldValue);
		$fieldValues[] = [
			$netzhirschCookieFieldModel->id,
			$csrfCookieFieldModel->id,
			$phpSessIdCookieFieldModel->id,
		];
		$fieldValue = serialize($fieldValues);
	} else {
		$fieldValue = $netzhirschCookieFieldModel->id;
	}
	
	return $fieldValue;
	}
}