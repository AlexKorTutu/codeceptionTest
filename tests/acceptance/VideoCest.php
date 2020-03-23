<?php

use \Facebook\WebDriver\WebDriverElement;

class VideoCest
{
    /**
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     *
     * Сценарий:
     * 1. Открыть https://yandex.ru/video/
     * 2. Ввести в поиск “ураган”
     * 3. Дождаться результатов поиска
     * 4. Навести курсор мыши на любое видео из левого блока
     * 5. Проверить, что у видео есть трейлер (превью картинка изменяется)
     */
    public function testTrailer(AcceptanceTester $I)
    {
        $I->amOnUrl('https://yandex.ru/video/');
        $I->fillField('.input__control', 'ураган');
        $I->click('.websearch-button__text');
        $I->waitForElementVisible('.thumb-image__preview');
        $I->moveMouseOver('.thumb-image__preview');

        $I->waitForElementChange('.thumb-image__preview', function (WebDriverElement $el)
        {
            return strpos($el->getAttribute('class'), 'thumb-preview__target_playing') !== false;
        }, 10);
        $I->seeElement('.thumb-preview__target_playing');
    }
}