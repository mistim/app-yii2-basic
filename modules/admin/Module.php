<?php
namespace app\modules\admin;

use Yii;

/**
 * Class Module
 * @package app\modules\admin
 */
class Module extends \yii\base\Module
{
    /** @var string $language */
    public $language = 'ru';

    /** @var string $defaultRoute */
    public $defaultRoute = 'main';

    /** @var string $identityClass */
    public $identityClass = 'app\modules\admin\models\AdminAuth';

    /** @var string $loginUrl */
    public $loginUrl = '/admin/main/login';

    /** @var string $panelName */
    public $panelName = 'CPanel';

    /** @var string $panelShortName */
    public $panelShortName = 'CP';

    protected static $mainPageForRole = [
        'Administrator'   => 'order',
        'Auditor'         => 'order',
        'Leader operator' => 'order',
        'Operator'        => 'order',
        'Marketer'        => 'product',
        'Underwriter'     => 'osgpo',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {

        Yii::configure($this, require(__DIR__ . '/config/main.php'));

        Yii::$app->name = $this->panelName;
        Yii::$app->language = $this->language;

        $this->configUser();
        $this->configTheme();
        $this->configTranslations();
        $this->setMainPage();

        parent::init();
    }

    /**
     * @inheritdoc
     */
    protected function configUser()
    {
        Yii::$app->user->identityClass = $this->identityClass;
        Yii::$app->user->loginUrl = $this->loginUrl;
        Yii::$app->user->enableAutoLogin = true;
        Yii::$app->user->identityCookie = [
            'name' => md5('admin' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function configTheme()
    {
        Yii::$app->view->theme = new \yii\base\Theme([
            'pathMap' => ['@app/views' => '@app/theme/adminlte/views'],
        ]);

        $this->layoutPath = Yii::getAlias('@app/theme/adminlte/views/layouts/');
        $this->layout = 'main';

        Yii::$app->assetManager->bundles = [];
    }

    /**
     * @inheritdoc
     */
    protected function configTranslations()
    {
        Yii::$app->language = $this->language;
        Yii::$app->i18n->translations['admin*'] = [
            'class'                 => 'yii\i18n\DbMessageSource',
            'sourceLanguage'        => 'en-US',
            //'enableCaching'         => true,
            //'cachingDuration'       => 60,
            'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation']
        ];
    }

    /**
     * @inheritdoc
     */
    protected function setMainPage()
    {
        if (!Yii::$app->user->isGuest)
        {
            $role = Yii::$app->user->identity->getRole();

            if (array_key_exists($role, self::$mainPageForRole))
            {
                $this->defaultRoute = self::$mainPageForRole[$role];
            }
        }
    }
}