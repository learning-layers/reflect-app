<?php

class SiteTest extends WebTestCase {

    public function testIndex() {
        $this->open('');
        $this->storeTextPresent('Welcome');
    }

    public function testContact() {
        $this->open('?r=site/contact');
        $this->storeTextPresent('Contact Us');
        $this->assertElementPresent('name=ContactForm[name]');

        $this->type('name=ContactForm[name]', 'tester');
        $this->type('name=ContactForm[email]', 'tester@example.com');
        $this->type('name=ContactForm[subject]', 'test subject');
        $this->click('name=yt0');
        $this->waitForTextPresent('Body cannot be blank.');
    }

    public function testLoginLogout() {
        $this->open('');
        // ensure the user is logged out
        if ($this->isTextPresent('Logout'))
            $this->clickAndWait('link=Logout (andreas@vratny.de)');
        $this->waitForElementPresent('link=Login');
        // test login process, including validation
        $this->clickAndWait('link=Login');
        $this->assertElementPresent('name=LoginForm[email]');
        $this->type('name=LoginForm[email]', 'andreas@vratny.de');
        $this->click('name=yt0');
        $this->waitForTextPresent('Password cannot be blank.');
        $this->type('name=LoginForm[password]', '123456');
        $this->click('name=yt0');
        $this->waitForElementPresent('link=Logout (andreas@vratny.de)');
        $this->assertTextNotPresent('Password cannot be blank.');
        $this->storeTextPresent('link=Logout (andreas@vratny.de)');

        // test logout process
        $this->assertTextNotPresent('Login');
        $this->clickAndWait('link=Logout (andreas@vratny.de)');
        $this->storeTextPresent('Login');
    }

}
