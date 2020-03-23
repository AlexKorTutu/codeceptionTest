<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */

    public function setSEOCookie($url)
    {
        $I = $this;
        // if snapshot exists - skipping setSEO
        if ($I->loadSessionSnapshot('setSEO')) {
            return;
        }
        $I->setCookie('test', 'seo');
        // logging in
        $I->amOnUrl($url);
        $I->saveSessionSnapshot('setSEO');
    }
}
