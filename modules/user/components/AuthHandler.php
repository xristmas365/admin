<?php
/**
 * AuthHandler.php
 *
 * @version    1.0
 * @package    AX project
 * @author     Paul Storre <1230840.ps@gmail.com>
 * @copyright  IndustrialAX LLC
 * @license    https://industrialax.com/license
 * @since      File available since v1.0
 */

namespace app\modules\user\components;

use Yii;
use app\models\User;
use app\models\Auth;
use yii\helpers\ArrayHelper;
use yii\authclient\ClientInterface;

/**
 * AuthHandler handles successful authentication via Yii auth component
 */
class AuthHandler
{
    
    /**
     * @var ClientInterface
     */
    private $client;
    
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }
    
    public function handle()
    {
        $attributes = $this->client->getUserAttributes();
        
        $id = ArrayHelper::getValue($attributes, 'id');
        $email = ArrayHelper::getValue($attributes, 'email');
        $first_name = ArrayHelper::getValue($attributes, 'given_name');
        $last_name = ArrayHelper::getValue($attributes, 'family_name');
        $picture = ArrayHelper::getValue($attributes, 'picture');
        $confirmed = ArrayHelper::getValue($attributes, 'verified_email');
        
        $auth = Auth::findOne(['source' => $this->client->getId(), 'source_id' => $id]);
        
        if(Yii::$app->user->isGuest) {
            if($auth) {
                $auth->user->touch('last_login_at');
                
                return Yii::$app->user->login($auth->user, getenv('SESSION_DURATION'));
            } else {
                if($email !== null && User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $this->client->getTitle()]),
                    ]);
                    
                    return false;
                } else {
                    $user = new User([
                        'email'         => $email,
                        'password'      => Yii::$app->security->generatePasswordHash($id),
                        'auth_key'      => Yii::$app->security->generateRandomString(),
                        'first_name'    => $first_name,
                        'last_name'     => $last_name,
                        'role'          => User::ROLE_USER,
                        'created_at'    => time(),
                        'updated_at'    => time(),
                        'last_login_at' => time(),
                        'confirmed'     => $confirmed,
                    ]);
                    
                    $transaction = Yii::$app->db->beginTransaction();
                    
                    if($user->save()) {
                        $auth = new Auth([
                            'user_id'   => $user->id,
                            'source'    => $this->client->getId(),
                            'source_id' => (string)$id,
                        ]);
                        if($auth->save()) {
                            $transaction->commit();
                            Yii::$app->user->login($user, getenv('SESSION_DURATION'));
                            
                            return true;
                        }
                    }
                    
                    return false;
                }
            }
        } else {
            if(!$auth) {
                $auth = new Auth([
                    'user_id'   => Yii::$app->user->id,
                    'source'    => $this->client->getId(),
                    'source_id' => (string)$id,
                ]);
                if($auth->save()) {
                    Yii::$app->getSession()->setFlash('success', [
                        Yii::t('app', 'Linked {client} account.', [
                            'client' => $this->client->getTitle(),
                        ]),
                    ]);
                    
                    return true;
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', 'Unable to link {client} account: {errors}', [
                            'client' => $this->client->getTitle(),
                            'errors' => json_encode($auth->getErrors()),
                        ]),
                    ]);
                    
                    return false;
                }
            } else {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app',
                        'Unable to link {client} account. There is another user using it.',
                        ['client' => $this->client->getTitle()]),
                ]);
                
                return false;
            }
        }
    }
    
}
