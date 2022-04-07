<?php

namespace app\modules\email\components;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use app\modules\user\models\User;
use yii\web\NotFoundHttpException;
use yii\base\InvalidConfigException;
use app\modules\email\models\EmailTemplate;

class Email extends Component
{
    
    /**
     * @var $template EmailTemplate|null
     */
    protected $template;
    
    /**
     * @var $users User[]|[]
     */
    protected $users;
    
    /**
     * @var $response []
     */
    
    protected $response;
    
    public function useTemplate($template_id)
    {
        $this->template = EmailTemplate::findOne($template_id);
        
        if(!$this->template) {
            throw new NotFoundHttpException('Template not Found');
        }
        
        return $this;
    }
    
    public function useTemplateWithKey($template_key)
    {
        $this->template = EmailTemplate::findOne(['template_key' => $template_key]);
        
        if(!$this->template) {
            throw new NotFoundHttpException('Template not Found');
        }
        
        return $this;
    }
    
    public function to(array $users)
    {
        $this->users = User::find()->select(['email', 'name', 'company'])->where(['id' => $users])->all();
        
        return $this;
        
    }
    
    public function send()
    {
        $mailer = Yii::$app->mailer;
        
        $messages = [];
        
        foreach($this->users as $user) {
            $controller = Yii::$app->controller;
            $controller->layout = '@app/mail/layouts/html.php';
           
            
            $content = $controller->renderContent(strtr($this->template->content, [
                '{{name}}'        => $user->name,
                '{{company}}'     => $user->company,
                '{{date}}'        => date('Y-m-d'),
                '{{product}}'     => 'Apple',
                '{{project}}'     => Yii::$app->name,
                '{{verify_link}}' => Url::toRoute(['/user/auth/verify', 'auth' => $user->auth_key], true),
                '{{reset_link}}'  => Url::toRoute(['/user/auth/password', 'auth' => $user->auth_key], true),
            ]));
            
            $messages[] = $mailer->compose()
                                 ->setTo($user->email)
                                 ->setFrom([getenv('MAIL_USER') => 'admin-ax.com'])
                                 ->setSubject($this->template->subject)
                                 ->setHtmlBody($content);
            
        }
        
        if(!$messages) {
            throw new InvalidConfigException('Messages are empty');
        }
        
        return $mailer->sendMultiple($messages);
        
    }
}
