<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\UserInfo;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $address;
    public $name;
    public $nif;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],


            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],


            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'min' => 2, 'max' => 255],

            ['nif', 'trim'],
            ['nif', 'required'],
            ['nif', 'integer'],
            ['nif', 'match', 'pattern' => '/\b\d{9}\b/'],
        ];
    }

    /**
     * Signs user up.
     *
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        $user->status = 10;

        if ($user->save()) {
            $userInfo = new UserInfo();
            $userInfo->user_id = $user->id;
            $userInfo->name = $this->name;
            $userInfo->address = $this->address;
            $userInfo->nif = $this->nif;
            $userInfo->save();
        }

        return $user;
    }

    public function update($id)
    {
        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne($id);
        if ($user === null) {
            return null; // Usuário não encontrado
        }

        $user->username = $this->username;
        $user->email = $this->email;

        // Apenas atualize a senha se um novo valor for fornecido
        if (!empty($this->password)) {
            $user->setPassword($this->password);
        }

        // Não precisa chamar generateAuthKey e generateEmailVerificationToken novamente

        $user->status = 10; // Certifique-se de definir o status do usuário conforme necessário

        // Salva o usuário e verifica se a operação foi bem-sucedida
        if (!$user->save()) {
            Yii::error('Erro ao salvar o usuário: ' . print_r($user->errors, true)); // Adiciona uma mensagem de log
            return null; // Falha ao salvar o usuário
        }

        // Agora vamos lidar com as informações do usuário (UserInfo)
        $userInfo = UserInfo::findOne(['user_id' => $id]);
        if ($userInfo === null) {
            $userInfo = new UserInfo();
            $userInfo->user_id = $user->id;
        }

        // Atualiza os campos das informações do usuário
        $userInfo->name = $this->name;
        $userInfo->address = $this->address;
        $userInfo->nif = $this->nif;

        // Salva as informações do usuário e verifica se a operação foi bem-sucedida
        if (!$userInfo->save()) {
            Yii::error('Erro ao salvar as informações do usuário: ' . print_r($userInfo->errors, true)); // Adiciona uma mensagem de log
            return null; // Falha ao salvar as informações do usuário
        }

        // Se tudo estiver bem, retorne o usuário
        return $user;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    public static function getPreviousUser($id)
    {
        return User::findIdentity($id);
    }
}
