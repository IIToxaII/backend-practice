<?php 

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage("/category.php");
        $I->see("[{\"category_id\":\"1\",\"name\":\"Processor\"},{\"category_id\":\"2\",\"name\":\"RAM\"},{\"category_id\":\"3\",\"name\":\"HDD\"}]");
        $I->amOnPage("/category.php?name=ram");
        $I->see("[{\"name\":\"HyperX 8GB\",\"price\":\"100.00\"},{\"name\":\"HyperX 16GB\",\"price\":\"200.00\"}]");
        $I->amOnPage("/category.php?name=hdd");
        $I->see("[{\"name\":\"WD 1TB\",\"price\":\"99.99\"},{\"name\":\"WD 500GB\",\"price\":\"49.99\"}]");
        $I->amOnPage("/category.php?name=processor");
        $I->see("[{\"name\":\"Ryzen 1600\",\"price\":\"159.99\"},{\"name\":\"Ryzen 1700\",\"price\":\"199.99\"}]");
        $I->amOnPage("/login.php");
        $I->see("clear");
        $I->amOnPage("/login.php?name=admin");
        $I->see("clear");
        $I->amOnPage("/login.php?password=admin");
        $I->see("clear");
        $I->amOnPage("/login.php?name=admin&password=wrong");
        $I->see("fail");
        $I->amOnPage("/login.php?name=wrong&password=admin");
        $I->see("fail");
        $I->amOnPage("/login.php?name=admin&password=admin");
        $I->see("ok");
        $I->amOnPage("/login.php");
        $I->see("isntGuest");
    }
}
