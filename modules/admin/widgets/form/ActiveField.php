<?php
/**
 * @author    Paul Storre <1230840.ps@gmail.com>
 * @package   Admin AX project
 * @version   1.0
 * @copyright Copyright (c) 2021, IndustrialAX LLC
 * @license   https://industrialax.com/license
 */

namespace app\modules\admin\widgets\form;

use Yii;
use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\MaskedInput;
use yii\helpers\ArrayHelper;
use app\modules\user\models\User;
use app\modules\user\models\Card;

/**
 * Class ActiveField
 * @package app\modules\admin\widgets\form
 */
class ActiveField extends \kartik\form\ActiveField
{
    
    public function phoneInput($options = [])
    {
        $defaultOptions = [
            'mask'    => '(999) 999-9999',
            'options' => [
                'placeholder' => '(555)-123-1234 Example',
            ],
        ];
        
        return parent::widget(MaskedInput::class, array_replace_recursive($defaultOptions, $options));
    }
    
    public function zipInput($options = [])
    {
        $defaultOptions = [
            'mask'    => '99999',
            'options' => [
                'placeholder' => '92100 Example',
            ],
        ];
        
        return parent::widget(MaskedInput::class, array_replace_recursive($defaultOptions, $options));
    }
    
    public function stripeCard($options = []) : string
    {
        if(Yii::$app->user->isGuest) {
            /**
             * Register Stripe v3 Library
             */
            Yii::$app->view->registerJsFile("https://js.stripe.com/v3/", ['position' => View::POS_HEAD]);
            
            $card = Html::tag('div', null, ['id' => 'card', 'class' => 'my-4']);
            $cardErrors = Html::tag('div', null, ['id' => 'card-errors', 'class' => 'text-center', 'role' => 'alert']);
            
            $this->registerStripeJs($options);
            
            $hiddenInput = $this->hiddenInput()->label(false);
            
            return $card . $cardErrors . $hiddenInput;
        } else {
            /**
             * @var User $user
             */
            $user = Yii::$app->user->identity;
            $userCards = ArrayHelper::map(Card::find()->where(['user_id'=>$user->id])->all(), 'source', 'number');
            
            $items = array_map(function($item) {
                return '**** **** **** '.$item;
            }, $userCards);
            
            return $this->radioList($items);
            
        }
        
    }
    
    protected function registerStripeJs($options)
    {
        $stripePK = getenv('STRIPE_PK');
        $formID = $this->form->id;
        $hiddenInputID = $this->getInputId();
        
        $defaultOptions = [
            'hidePostalCode' => true,
            'style'          => [
                'base' => [
                    'color'         => '#303238',
                    'fontSize'      => '16px',
                    'fontWeight'    => '400',
                    'fontFamily'    => '"Open Sans", sans-serif',
                    'fontSmoothing' => 'antialiased',
                    '::placeholder' => [
                        'color' => '#aab7c4',
                    ],
                ],
            ],
        ];
        
        $options = Json::encode(array_replace_recursive($defaultOptions, $options));
        
        $js = <<<JS
                    const stripe = Stripe('$stripePK')
                    const elements = stripe.elements()
                    const card = elements.create("card", $options)
                    card.mount("#card")
                    card.addEventListener('change', function(event) {
                      var displayError = document.getElementById('card-errors')
                      if (event.error) {
                        displayError.textContent = event.error.message
                      } else {
                        displayError.textContent = ''
                      }
                    })
                    
                    $(document).on('click', '#$formID :submit', function(e) {
                      e.preventDefault()
                      const submitBtn = $(this)
                      submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...')
                      const form = $('#$formID')
                      const hiddenInput = $('#$hiddenInputID')
                      const errors = $('#card-errors')
                      stripe.createToken(card).then(function(result) {
                        if (result.error) {
                          errors.text(result.error.message)
                          submitBtn.prop('disabled', false).text('Proceed')
                        } else {
                          hiddenInput.val(result.token.id)
                          form.submit()
                        }
                      })
                    })
JS;
        
        Yii::$app->view->registerJs($js);
    }
    
}
