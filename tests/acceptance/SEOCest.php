<?php

class SEOCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    /**
     * @param AcceptanceTester $I
     * @param \Codeception\Example $example
     * @dataProvider pageProvider
     */
    public function seoTest(AcceptanceTester $I, \Codeception\Example $example)
    {
        $url = $example[0];
        $title = $example[1];
        $descr = $example[2];
        $I->amOnUrl($url);
        $I->setSEOCookie($url);
        $I->seeInTitle($title);
        try {
            $actual = $I->grabAttributeFrom('meta[name=\'description\']', 'content');
            $I->seeElementInDOM('meta[name=\'description\'][content=\'' . $descr . '\']');
        } catch (Exception $e) {
            //Выводим более читаемое для всех описание ошибки:
            throw new Exception("meta description на странице $url не соответствует ожидаемому" . PHP_EOL .
            "actual: $actual" . PHP_EOL .
            "expected: $descr" . PHP_EOL);
        }
    }

    /**
     * @return array
     */
    protected function pageProvider() // alternatively, if you want the function to be public, be sure to prefix it with `_`
    {
        $handle = fopen(__DIR__ . '/../_data/ssseo.csv', "r");
        $rows = [];
        while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
            $rows[] = $data;
        }
        fclose($handle);

        return $rows;
    }
}
