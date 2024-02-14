<?php

use yii\db\Migration;

/**
 * Class m240214_121520_create_rbac
 */
class m240214_121520_create_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        $roleAdmin = $auth->createRole('admin');
        $auth->add($roleAdmin);
        $roleUser  = $auth->createRole('user');
        $auth->add($roleUser);

        $permProdutoManagement = $auth->createPermission('produtoManagement');
        $auth->add($permProdutoManagement);
        $permUserManagement = $auth->createPermission('userManagement');
        $auth->add($permUserManagement);
        $permfaturaManagement = $auth->createPermission('faturaManagement');
        $auth->add($permfaturaManagement);

        $auth->addChild($roleAdmin, $permProdutoManagement);
        $auth->addChild($roleAdmin, $permUserManagement);
        $auth->addChild($roleUser, $permfaturaManagement);

        $auth->addChild($roleAdmin, $roleUser);

        $auth->assign($roleAdmin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }
}
